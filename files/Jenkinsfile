pipeline {
    agent any
    stages {
        stage('Build') {
            steps {
                sh 'cp /var/www/configs/skeleton/.env .env'
                sh 'sudo docker image prune -f'
                sh 'sudo docker-compose -f docker/docker-compose.yml build'
            }
        }
        stage('Deploy') {
            steps {
                sh 'sudo docker-compose -f docker/docker-compose.yml up -d'
            }
        }
    }
}