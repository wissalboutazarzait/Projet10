pipeline {
    agent any  

    environment {
        PHP_HOME = '/usr/bin/php'
    }

    stages {

        stage('Build') {
            steps {
                script {

                    echo 'Installing dependencies...'
                    sh 'composer install --no-interaction --prefer-dist' 
                }
            }
        }

        stage('Test') {
            steps {
                script {
                    echo 'Running PHPUnit tests...'

                    sh 'php vendor/bin/phpunit --configuration phpunit.xml'
                }
            }
        }
    }

    post {
        always {
            echo 'Pipeline finished.'
        }
        
        success {
            echo 'Build and tests passed successfully.'
        }

        failure {
            echo 'Build or tests failed.'
        }
    }
}
