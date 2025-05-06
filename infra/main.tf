provider "aws" {
  region = var.aws_region
}

resource "aws_elastic_beanstalk_application" "php_app" {
  name        = "markdown2video-app"
  description = "PHP application deployed with Elastic Beanstalk"
}

resource "aws_elastic_beanstalk_environment" "php_app_env" {
  name                = "markdown2video-env"
  application         = aws_elastic_beanstalk_application.php_app.name
  solution_stack_name = "64bit Amazon Linux 2 v4.6.1 running PHP 8.4"
}

resource "aws_db_instance" "mysql_db" {
  identifier           = "markdown2video-db"
  allocated_storage    = 20
  engine               = "mysql"
  engine_version       = "8.0"
  instance_class       = "db.t3.micro"
  db_name              = var.db_name
  username             = var.db_username
  password             = var.db_password
  publicly_accessible  = true
  skip_final_snapshot  = true
}
