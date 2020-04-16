pipeline {
    agent any
    stages {
        stage('Build - Staging') {
            when {
                branch 'staging'
            }
            steps {
                sh 'sudo docker image prune -f'
                sh 'sudo docker-compose -f docker-compose.stg.yml build'
            }
        }
        stage('Build - Production') {
            when {
                branch 'master'
            }
            steps {
                sh 'sudo docker image prune -f'
                sh 'sudo docker-compose -f docker-compose.prod.yml build'
            }
        }
        stage('Deploy - Staging') {
            when {
                branch 'staging'
            }
            steps {
                sh 'sudo docker-compose -f docker-compose.stg.yml up -d'
            }
        }
        stage('Deploy - Production') {
            when {
                branch 'master'
            }
            steps {
                sh 'sudo docker-compose -f docker-compose.prod.yml up -d'
            }
        }
    }
}