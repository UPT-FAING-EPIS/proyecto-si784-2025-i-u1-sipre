output "elastic_beanstalk_url" {
  value = aws_elastic_beanstalk_environment.php_app_env.endpoint_url
}
