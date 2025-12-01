pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main', url: 'https://github.com/naufalraihanif/Seminar-Register-Web-Based.git'
            }
        }

        stage('Install Dependencies') {
            steps {
                bat 'composer install'
            }
        }

        stage('Run Unit Tests') {
            steps {
                bat 'vendor\\bin\\phpunit --testdox'
            }
        }
    }
}
