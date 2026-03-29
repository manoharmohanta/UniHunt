<?php

namespace App\Libraries;

class AIService
{
  protected $apiKey;
  protected $apiUrl = 'https://openrouter.ai/api/v1/chat/completions';

  public function __construct()
  {
    // Try environment variables first
    $this->apiKey = env('openai_api_key_paid') ?: env('openai_api_key');

    // Fallback to DB if .env is missing
    if (empty($this->apiKey)) {
      $db = \Config\Database::connect();
      $configToken = $db->table('site_config')->where('config_key', 'openai_api_key')->get()->getRowArray();
      if ($configToken) {
        $val = $configToken['config_value'];
        $decoded = json_decode($val, true);
        $this->apiKey = (json_last_error() === JSON_ERROR_NONE) ? $decoded : trim($val, "\"' ");
      }
    }
  }

  protected function getModel()
  {
    $db = \Config\Database::connect();
    $configModel = $db->table('site_config')->where('config_key', 'ai_model')->get()->getRowArray();
    if ($configModel) {
      $val = $configModel['config_value'];
      $decoded = json_decode($val, true);
      return (json_last_error() === JSON_ERROR_NONE) ? $decoded : trim($val, "\"' ");
    }
    return 'arcee-ai/trinity-large-preview:free';
  }

  public function extractCourseDetails($url)
  {
    // 1. Fetch the content of the URL
    $content = $this->fetchUrlContent($url);
    if (!$content) {
      return ['error' => 'Could not fetch content from the provided URL.'];
    }

    // 2. Prepare the prompt for AI
    $prompt = "You are a professional academic data extractor. Extract course information from the following HTML/text content into a JSON format.
        
        The JSON should follow this structure:
        {
          \"name\": \"Course Name\",
          \"level\": \"Bachelors/Masters/PhD/Diploma\",
          \"field\": \"Field of Study (e.g. Computer Science)\",
          \"duration_months\": 24,
          \"tuition_fee\": 15000.00,
          \"stem\": true/false,
          \"intake_months\": [\"Jan\", \"Sep\"],
          \"requirements\": {
             \"ielts_score\": 6.5,
             \"toefl_score\": 80,
             \"pte_score\": 58,
             \"duolingo_score\": 110,
             \"gpa_requirement\": \"3.0/4.0\",
             \"work_exp\": 2,
             \"gmat_score\": 600,
             \"gre_score\": 310
          },
          \"notes\": \"Summary or important notes about the course\",
          \"syllabus\": \"Information about modules, curriculum or key subjects\",
          \"career_outcomes\": \"Potential jobs, career paths or industry connections\",
          \"employment_rate\": \"Percentage (e.g. 95%)\",
          \"avg_salary\": \"Average starting salary (e.g. $60,000)\",
          \"top_roles\": \"List of common hiring roles\"
        }

        Only return the JSON. Do not include any explanation or markdown tags.
        If a field is not found, use null. Duration should be in months. Level must be one of [Bachelors, Masters, PhD, Diploma]. Intake months must be abbreviated (Jan, Feb, etc).

        Content:
        " . substr($content, 0, 15000); // Truncate to stay within context limits

    // 3. Call OpenRouter API
    return $this->callAI($prompt);
  }

  public function generateCourseInsights($data)
  {
    $prompt = "You are a professional academic consultant specializing in global student recruitment. 
        Based on the following course details, generate realistic, highly engaging, and helpful insights for a prospective student.
        
        Course Details:
        - University: " . ($data['university'] ?? 'Unknown University') . "
        - Course Name: " . ($data['name'] ?? 'Unknown Course') . "
        - Level: " . ($data['level'] ?? 'N/A') . "

        Provide the following in strictly valid JSON format:
        {
          \"field\": \"Specific field of study (e.g. Artificial Intelligence, Marketing Management)\",
          \"credits\": \"Suggested total credits for this level of program\",
          \"notes\": \"A 3-4 sentence professional summary of why this specific course is a strong choice at this university, mentioning academic reputation and facilities.\",
          \"syllabus\": \"A comma separated list of 6-8 core modules or key subjects likely to be covered.\",
          \"career_outcomes\": \"Common career paths, target industries, and professional opportunities for graduates.\",
          \"employment_rate\": \"Generic estimated employment rate percentage (e.g., 90-95%) based on global university standards.\",
          \"avg_salary\": \"Typical starting salary range (e.g., $60k - $85k) or equivalent currency.\",
          \"top_roles\": \"3-4 specific Job Titles graduates often obtain (e.g., Solutions Architect, Finance Manager).\"
        }

        Only return the JSON. Do not include any explanation, markdown formatting, or preamble.";

    return $this->callAI($prompt);
  }

  public function generateCounsellorRecommendations($studentProfile, $universities, $courses)
  {
    $prompt = "You are an expert university counsellor with deep knowledge of global higher education.

Student Profile:
" . json_encode($studentProfile, JSON_PRETTY_PRINT) . "

Available Universities in Database:
" . json_encode(array_slice($universities, 0, 50), JSON_PRETTY_PRINT) . "

Available Courses in Database:
" . json_encode(array_slice($courses, 0, 100), JSON_PRETTY_PRINT) . "

Your task:
1. Analyze the student's profile (academic background, test scores, budget, preferences, career goals)
2. Match them with the BEST universities and courses from the provided database
3. Consider ALL requirements (GPA, test scores, work experience, budget)
4. Rank at least 5 recommendations by fit score (1-100)
5. Provide detailed reasoning for each recommendation
6. If no perfect matches exist in the database, you MAY suggest 1-2 alternatives not in the database

Return VALID JSON with this structure:
{
  \"top_recommendations\": [
    {
      \"university_id\": 123,
      \"university_name\": \"University Name\",
      \"course_id\": 456,
      \"course_name\": \"Course Name\",
      \"fit_score\": 95,
      \"match_reasons\": [\"Reason 1\", \"Reason 2\", \"Reason 3\"],
      \"requirements_met\": {\"gpa\": true, \"ielts\": true, \"budget\": true},
      \"estimated_total_cost\": \"$50,000 for 2 years\",
      \"career_alignment\": \"How this aligns with student's goals\"
    }
  ],
  \"alternative_suggestions\": [
    {
      \"university_name\": \"Alternative University (not in DB)\",
      \"course_name\": \"Alternative Course\",
      \"why_suggested\": \"Explanation\",
      \"estimated_cost\": \"\$XX,XXX\"
    }
  ],
  \"action_plan\": [
    \"Step 1: Action item\",
    \"Step 2: Action item\"
  ],
  \"additional_notes\": \"Any important advice or considerations\"
}

Only return JSON. No markdown, no explanations.";

    return $this->callAI($prompt);
  }

  public function generateEmailCampaign($data)
  {
    $prompt = "You are an Email Campaign Engine for a SaaS platform.
        Your task is to generate structured email queue data based on:
        1. The type of email to send: " . ($data['type'] ?? 'Newsletter') . "
        2. The target audience segment: " . ($data['segment'] ?? 'All Users') . "
        3. The campaign goal: " . ($data['goal'] ?? 'Engagement') . "
        4. Tone and urgency level: " . ($data['tone'] ?? 'Professional') . "

        You must NOT send emails.
        You must ONLY prepare email queue entries that can be stored in a database.

        Return a VALID JSON object with the following fields:
        - email_subject
        - email_body_html (HTML content representing the INNER BODY of the email. Do NOT include <html>, <head>, or <body> tags. Use tags like <h1>, <p>, <ul>, <li>, <strong>, and <a class='btn'> for buttons.)
        - email_body_text (Plain text version)
        - target_audience_rules (JSON object defining the rules to match the segment users, e.g. {\"gpa_min\": 3.0})
        - priority (low | medium | high)
        - scheduled_at (relative time string like 'now', 'tomorrow 10 AM', 'after 2 hours')
        - campaign_tag (a short string identifier)

        Only return the JSON. Do not include any explanation or markdown formatting.";

    return $this->callAI($prompt);
  }

  public function generateTestPrepTopic($type)
  {
    $prompt = "You are an expert exam preparation instructor. Generate a single, RANDOM, realistic, and challenging exam topic title or question prompt.
        
        Module Type: " . ucfirst($type) . "
        Random Seed: " . rand(1000, 9999) . "

        Requirements:
        - For Writing / Analytical Writing: Provide a unique essay prompt (Issue or Argument task), or report title.
        - For Speaking: Provide a Cue Card topic or discussion question.
        - For Quantitative / Math: Provide a topic title (e.g., 'Advanced Algebra - Quadratic Equations', 'Data Interpretation Set 1').
        - For Verbal / Reading: Provide a passage title or topic (e.g., 'Reading Comprehension: 19th Century Literature', 'Sentence Equivalence Practice').
        - The output should be a concise topic VIDEO TITLE or QUESTION PROMPT.
        - Ensure variety in themes and difficulty.

        Return strictly valid JSON format:
        {
          \"topic\": \"The generated topic text goes here\"
        }

        Only return the JSON. No explanation.";

    return $this->callAI($prompt, 0.9);
  }

  public function predictCareer($profile)
  {
    $prompt = "You are a specialized career counselor and industry analyst. 
        Analyze the following student profile and predict their career trajectory based on their academic choice.
        
        Student Profile:
        " . json_encode($profile, JSON_PRETTY_PRINT) . "

        Provide the following in strictly valid JSON format:
        {
          \"course\": \"" . ($profile['course_choice'] ?? 'Selected Course') . "\",
          \"career_path_summary\": \"A 2-3 sentence overview of the career outlook for this field.\",
          \"top_roles\": [
            {\"title\": \"Job Title 1\", \"description\": \"Brief description of what they do.\"},
            {\"title\": \"Job Title 2\", \"description\": \"Brief description.\"}
          ],
          \"salary_prediction\": {
            \"entry_level\": \"\$XX,XXX - \$XX,XXX\",
            \"mid_level\": \"\$XX,XXX - \$XX,XXX\",
            \"senior_level\": \"\$XXX,XXX+\",
            \"currency\": \"USD\"
          },
          \"market_demand\": \"High/Medium/Stable\",
          \"growth_rate\": \"XX% annually\",
          \"top_industries\": [\"Industry 1\", \"Industry 2\"],
          \"recommended_skills\": [\"Skill 1\", \"Skill 2\", \"Skill 3\"]
        }

        Only return matching JSON. No markdown, no explanations.";

    return $this->callAI($prompt);
  }

  protected function fetchUrlContent($url)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $output = curl_exec($ch);
    curl_close($ch);

    if (!$output)
      return false;

    // Simple HTML to Text conversion to reduce token usage
    $text = strip_tags($output);
    $text = preg_replace('/\s+/', ' ', $text);
    return trim($text);
  }

  protected function callAI($prompt, $temperature = 0.7)
  {
    $data = [
      'model' => $this->getModel(),
      'messages' => [
        ['role' => 'user', 'content' => $prompt]
      ],
      'temperature' => $temperature
    ];

    $ch = curl_init($this->apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Authorization: Bearer ' . $this->apiKey,
      'Content-Type: application/json',
      'HTTP-Referer: http://localhost', // Required by OpenRouter
      'X-Title: Unisearch Admin'
    ]);

    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
      return ['error' => 'API Error: ' . $err];
    }

    $result = json_decode($response, true);
    if (isset($result['choices'][0]['message']['content'])) {
      $content = $result['choices'][0]['message']['content'];
      // Clean markdown blocks if present
      $content = preg_replace('/```json\s*|```/', '', $content);
      $decoded = json_decode(trim($content), true);
      if ($decoded)
        return $decoded;

      return ['error' => 'AI returned invalid JSON: ' . substr($content, 0, 100)];
    }

    $errorMsg = $result['error']['message'] ?? 'Unknown API error';
    return ['error' => 'Failed to parse AI response: ' . $errorMsg];
  }
}
