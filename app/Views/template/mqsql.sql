CREATE DATABASE unihunt CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE unihunt;
-- 1. USERS & AUTHORIZATION
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL,
    description TEXT
);
CREATE TABLE users (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    role_id INT,
    name VARCHAR(100),
    email VARCHAR(150) UNIQUE NOT NULL,
    phone VARCHAR(150) UNIQUE NOT NULL,
    password_hash VARCHAR(255),
    is_verified BOOLEAN DEFAULT FALSE,
    status ENUM('active','blocked','deleted') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);
-- 2. LOCATION HIERARCHY
CREATE TABLE countries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code CHAR(3) UNIQUE,
    name VARCHAR(100),
    currency VARCHAR(10),
    living_cost_min DECIMAL(10,2),
    living_cost_max DECIMAL(10,2),
    gic_amount DECIMAL(10,2), -- Canada
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE states (
    id INT AUTO_INCREMENT PRIMARY KEY,
    country_id INT,
    name VARCHAR(100),
    FOREIGN KEY (country_id) REFERENCES countries(id)
);
CREATE TABLE cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    country_id INT,
    name VARCHAR(100),
    living_cost DECIMAL(10,2),
    FOREIGN KEY (country_id) REFERENCES countries(id)
);


CREATE TABLE exchange_rates (
    currency VARCHAR(10),
    rate_to_usd DECIMAL(10,4),
    updated_at TIMESTAMP
);
CREATE TABLE visa_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    country_id INT,
    name VARCHAR(50)
);


-- 3. UNIVERSITIES & COURSES
CREATE TABLE universities (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    country_id INT,
    state_id INT,
    name VARCHAR(255),
    type ENUM('public','private'),
    website VARCHAR(255),
    ranking INT,
    stem_available BOOLEAN,
    tuition_fee_min DECIMAL(10,2),
    tuition_fee_max DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (country_id) REFERENCES countries(id),
    FOREIGN KEY (state_id) REFERENCES states(id)
);
CREATE TABLE university_images (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    university_id BIGINT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    caption VARCHAR(255) NULL,
    is_main BOOLEAN DEFAULT FALSE,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (university_id) REFERENCES universities(id)
);
CREATE TABLE courses (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    university_id BIGINT,
    name VARCHAR(255),
    level ENUM('Diploma','Bachelors','Masters','PhD'),
    field VARCHAR(100),
    stem BOOLEAN,
    duration_months INT,
    tuition_fee DECIMAL(10,2),
    intake_months JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (university_id) REFERENCES universities(id)
);
-- 4. FLEXIBLE REQUIREMENTS SYSTEM (KEY PART)
CREATE TABLE requirement_parameters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE,
    label VARCHAR(100),
    type ENUM('number','boolean','string','range','list')
);


CREATE TABLE country_requirements (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    country_id INT,
    parameter_id INT,
    value JSON,
    is_mandatory BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (country_id) REFERENCES countries(id),
    FOREIGN KEY (parameter_id) REFERENCES requirement_parameters(id)
);
CREATE TABLE university_requirements (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    university_id BIGINT,
    parameter_id INT,
    value JSON,
    FOREIGN KEY (university_id) REFERENCES universities(id),
    FOREIGN KEY (parameter_id) REFERENCES requirement_parameters(id)
);
CREATE TABLE course_requirements (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    course_id BIGINT,
    parameter_id INT,
    value JSON,
    FOREIGN KEY (course_id) REFERENCES courses(id),
    FOREIGN KEY (parameter_id) REFERENCES requirement_parameters(id)
);


-- 5. Deadlines
CREATE TABLE deadlines (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,    entity_type ENUM('country','university','course') NOT NULL,
    entity_id BIGINT NOT NULL,    
    intake VARCHAR(20) NULL, 
    -- Fall, Spring, Summer, Winter, All    
    deadline_type ENUM(
        'application',
        'document',
        'scholarship',
        'visa',
        'deposit'
    ) NOT NULL,    
    deadline_date DATE NULL,
    is_rolling BOOLEAN DEFAULT FALSE,    
    notes TEXT NULL,    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,    
    INDEX idx_entity (entity_type, entity_id),
    INDEX idx_intake (intake),
    INDEX idx_deadline_type (deadline_type)
);


-- 6. ADMISSION PROCESS VERSIONING
CREATE TABLE admission_processes (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    country_id INT,
    version VARCHAR(20),
    steps JSON,
    effective_from DATE,
    effective_to DATE,
    FOREIGN KEY (country_id) REFERENCES countries(id)
);


-- 7. BLOG & CONTENT
CREATE TABLE blogs (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    author_id BIGINT,
    title VARCHAR(255),
    slug VARCHAR(255) UNIQUE,
    content LONGTEXT,
    status ENUM('draft','published'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id)
);
-- 8. AI SERVICES MODULE
CREATE TABLE ai_tools (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    description TEXT,
    price DECIMAL(10,2) DEFAULT 0.00,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
CREATE TABLE ai_requests (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT,
    tool_id INT,
    input_data JSON,
    output_data JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (tool_id) REFERENCES ai_tools(id)
);
-- 9. USER INTERACTION
CREATE TABLE bookmarks (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT,
    entity_type ENUM('university','course','blog'),
    entity_id BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE comments (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT,
    entity_type ENUM('blog','university','course'),
    entity_id BIGINT,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);


CREATE TABLE search_history (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT NULL,
    query TEXT,
    filters JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE visitors (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45),
    country VARCHAR(50),
    user_agent TEXT,
    visited_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- 10. EMAIL & MARKETING
CREATE TABLE email_queue (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    recipient VARCHAR(150),
    subject VARCHAR(255),
    body TEXT,
    status ENUM('pending','sent','failed'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE subscribers (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) UNIQUE,
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- 11. SITE CONFIG
CREATE TABLE site_config (
    config_key VARCHAR(100) PRIMARY KEY,
    config_value JSON
);
CREATE TABLE import_logs (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  entity ENUM('university','course'),
  total INT,
  success INT,
  failed INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
