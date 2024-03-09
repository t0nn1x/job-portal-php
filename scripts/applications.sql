CREATE TABLE applications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  listing_id INT NOT NULL,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  portfolio_website VARCHAR(255),
  resume VARCHAR(255),
  cover_letter TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (listing_id) REFERENCES listings(id)
);
