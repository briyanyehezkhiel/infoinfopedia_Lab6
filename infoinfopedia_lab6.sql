CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE posts (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);



SELECT posts.*, users.username
FROM posts
JOIN users ON posts.user_id = users.id
WHERE posts.content ILIKE '%tes%' OR users.username ILIKE '%tes%'
ORDER BY posts.created_at DESC;

select * from posts

						
select username,password from users