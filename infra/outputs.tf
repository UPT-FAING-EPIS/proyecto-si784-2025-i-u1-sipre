output "elastic_beanstalk_url" {
  value = aws_elastic_beanstalk_environment.php_app_env.endpoint_url
}
output "db_endpoint" {
  description = "Endpoint del servidor de base de datos"
  value       = aws_db_instance.mysql_db.endpoint
}

output "db_port" {
  description = "Puerto de conexión del RDS"
  value       = aws_db_instance.mysql_db.port
}
