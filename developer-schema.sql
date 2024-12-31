-- Developer accounts table
CREATE TABLE developer_accounts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    org_name VARCHAR(255) NOT NULL,
    website VARCHAR(255),
    app_description TEXT,
    api_usage ENUM('low', 'medium', 'high') NOT NULL,
    status ENUM('pending', 'active', 'suspended') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Developer API keys table
CREATE TABLE developer_api_keys (
    id INT PRIMARY KEY AUTO_INCREMENT,
    developer_id INT NOT NULL,
    api_key VARCHAR(64) NOT NULL UNIQUE,
    api_secret VARCHAR(64) NOT NULL,
    name VARCHAR(100),
    environment ENUM('sandbox', 'production') NOT NULL DEFAULT 'sandbox',
    status ENUM('active', 'revoked') NOT NULL DEFAULT 'active',
    last_used_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (developer_id) REFERENCES developer_accounts(id)
);

-- Integration types table
CREATE TABLE developer_integration_types (
    id INT PRIMARY KEY AUTO_INCREMENT,
    developer_id INT NOT NULL,
    integration_type ENUM('web', 'mobile', 'server') NOT NULL,
    FOREIGN KEY (developer_id) REFERENCES developer_accounts(id)
);

-- API usage logs
CREATE TABLE api_usage_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    api_key_id INT NOT NULL,
    endpoint VARCHAR(255) NOT NULL,
    method VARCHAR(10) NOT NULL,
    response_code INT NOT NULL,
    response_time INT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (api_key_id) REFERENCES developer_api_keys(id)
);

-- Create indexes
CREATE INDEX idx_dev_email ON developer_accounts(email);
CREATE INDEX idx_api_key ON developer_api_keys(api_key);
CREATE INDEX idx_usage_timestamp ON api_usage_logs(timestamp);
