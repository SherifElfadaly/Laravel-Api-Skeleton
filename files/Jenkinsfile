pipeline {
    agent any
    stages {
        stage('Build') {
            steps {
                sh 'sudo mkdir -p /var/www/html/skeleton'
                sh 'sudo cp -r * /var/www/html/skeleton'
                sh 'cd /var/www/html/skeleton'
                sh 'sudo cp /var/www/configs/skeleton/.env .env'
                sh 'sudo docker image prune -f'
                sh 'sudo docker-compose -f docker/docker-compose.yml build'
            }
        }
        stage('Deploy') {
            steps {
                sh 'docker-compose -f docker/docker-compose.yml up -d'
            }
        }
    }
}