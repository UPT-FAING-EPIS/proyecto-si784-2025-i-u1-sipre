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
