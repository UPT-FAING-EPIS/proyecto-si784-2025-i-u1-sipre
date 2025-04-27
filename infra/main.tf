provider "aws" {
  region = var.aws_region
}

resource "aws_elastic_beanstalk_application" "php_app" {
  name        = "my-php-app"
  description = "PHP application deployed with Elastic Beanstalk"
}

resource "aws_elastic_beanstalk_environment" "php_app_env" {
  name                = "my-php-app-env"
  application         = aws_elastic_beanstalk_application.php_app.name
  solution_stack_name = "64bit Amazon Linux 2 v3.3.6 running PHP 7.4"
}
