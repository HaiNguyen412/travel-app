
# Setup with docker UNIX

- sudo docker-compose up -d
- Để tránh xảy ra một số lỗi không đáng có mn nên sử dụng lệnh sau trước khi tắt code/tắt máy:
- sudo docker-compose down

# Set up set in server docker:
sudo docker exec -it mock-project_php_1 bash
- 

- composer update

- cp .env.example .env
- php artisan key:generate



# Một số chức năng:
- Truy cập giao diện code trên web: http://localhost:8000
- Truy cập mysql trên web: http://localhost:8080