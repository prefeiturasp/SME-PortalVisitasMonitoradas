docker_compose('docker-compose.yml')
docker_build('wordpress/visitasmonitoradas', '.',
  live_update = [
    sync('.', '/var/www/html')
  ])