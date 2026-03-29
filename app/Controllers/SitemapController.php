<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;

class SitemapController extends BaseController
{
    public function index()
    {
        helper('text');
        $data = [
            base_url('sitemap-universities.xml'),
            base_url('sitemap-courses.xml'),
            base_url('sitemap-blogs.xml'),
            base_url('sitemap-pages.xml'),
        ];

        return $this->response->setContentType('text/xml')
            ->setBody($this->generateIndexXml($data));
    }

    public function pages()
    {
        // Static pages
        $urls = [
            base_url(),
            base_url('about'),
            base_url('contact'),
            base_url('blog'),
            base_url('universities'),
            base_url('ai-tools'),
            base_url('events'),
        ];
        return $this->response->setContentType('text/xml')
            ->setBody($this->generateUrlXml($urls));
    }

    public function universities()
    {
        helper('text');
        $model = new \App\Models\UniversityModel();
        // Join with countries to get the country slug for the URL structure: /universities/{country_slug}/{uni_slug}
        // Assuming Route: $routes->get('(:segment)/(:segment)', 'Home::university_details/$1/$2'); inside 'universities' group?
        // Wait, Home.php: university_details($country_slug, $uni_slug)
        // Route: $routes->group('universities'... $routes->get('(:segment)/(:segment)', 'Home::university_details/$1/$2')
        // So URL is: base_url("universities/{country_slug}/{uni_slug}")

        $universities = $model->select('universities.slug, universities.created_at, countries.slug as country_slug')
            ->join('countries', 'countries.id = universities.country_id')
            ->where('universities.ranking >', 0) // Optional: only index ranked/active ones
            ->findAll();

        $urls = [];
        foreach ($universities as $uni) {
            $urls[] = [
                'loc' => base_url("universities/{$uni['country_slug']}/{$uni['slug']}"),
                'lastmod' => $uni['created_at']
            ];
        }

        return $this->response->setContentType('text/xml')
            ->setBody($this->generateUrlXml($urls));
    }

    public function courses()
    {
        helper('text');
        $model = new \App\Models\CourseModel();
        // Route: courses/country/uni/course_id OR courses/category/course_id ?? 
        // Let's check Routes.php again: 
        // $routes->get('(:segment)/(:segment)/(:any)', 'Home::course_details/$1/$2/$3'); // Country/Uni/Course
        // And Home.php course_details($segment1, $segment2, $segment3) 
        // It reconstructs using IDs or Slugs.
        // Best SEO URL seems to be: courses/{country_slug}/{uni_slug}/{course_slug}

        // We need to fetch country and uni slugs.
        $courses = $model->select('courses.id, courses.name, courses.created_at, universities.slug as uni_slug, countries.slug as country_slug')
            ->join('universities', 'universities.id = courses.university_id')
            ->join('countries', 'countries.id = universities.country_id')
            ->orderBy('courses.id', 'DESC')
            ->limit(5000) // Chunking might be needed for huge datasets, but 5k is safe for now
            ->find();

        $urls = [];
        foreach ($courses as $course) {
            // We use url_title for course slug as established in Home.php analysis
            $courseSlug = url_title($course['name'], '-', true);
            $urls[] = [
                'loc' => base_url("courses/{$course['country_slug']}/{$course['uni_slug']}/{$courseSlug}"),
                'lastmod' => $course['created_at']
            ];
        }

        return $this->response->setContentType('text/xml')
            ->setBody($this->generateUrlXml($urls));
    }

    public function blogs()
    {
        helper('text');
        $model = new \App\Models\BlogModel();
        // Route: $routes->group('blog'... $routes->get('(:segment)/(:any)', 'Home::blog_single/$1/$2');
        // URL: blog/{category_slug}/{slug}

        $blogs = $model->select('slug, category, created_at')
            ->where('status', 'published')
            ->findAll();

        $urls = [];
        foreach ($blogs as $blog) {
            $catSlug = url_title($blog['category'], '-', true);
            $urls[] = [
                'loc' => base_url("blog/{$catSlug}/{$blog['slug']}"),
                'lastmod' => $blog['created_at']
            ];
        }

        return $this->response->setContentType('text/xml')
            ->setBody($this->generateUrlXml($urls));
    }

    private function generateIndexXml(array $sitemaps)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($sitemaps as $url) {
            $xml .= '<sitemap>';
            $xml .= '<loc>' . esc($url) . '</loc>';
            $xml .= '<lastmod>' . date('c') . '</lastmod>';
            $xml .= '</sitemap>';
        }
        $xml .= '</sitemapindex>';
        return $xml;
    }

    private function generateUrlXml(array $urls)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($urls as $entry) {
            $url = is_array($entry) ? $entry['loc'] : $entry;

            // Date handling
            $rawDate = is_array($entry) ? ($entry['lastmod'] ?? null) : null;
            $lastmod = date('c'); // Default to now

            if ($rawDate) {
                // Try strtotime
                $timestamp = strtotime($rawDate);
                if ($timestamp !== false && $timestamp > 0) {
                    $lastmod = date('c', $timestamp);
                }
            }

            $xml .= '<url>';
            $xml .= '<loc>' . esc($url) . '</loc>';
            $xml .= '<lastmod>' . $lastmod . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.8</priority>';
            $xml .= '</url>';
        }
        $xml .= '</urlset>';
        return $xml;
    }
}
