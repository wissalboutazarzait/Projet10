pipeline {
    agent any
    
    environment {
        DOCKER_IMAGE = 'wissal041/projet10-php'  
        DOCKER_TAG = 'latest'  
        REGISTRY = 'docker.io'  
        SONARQUBE_SERVER = 'SonarQube'  
        DEPLOY_SERVER = 'user@serveur-distant' 
    }

    stages {
        
        stage('Checkout') {
    steps {
        script {
            echo 'Récupération du code depuis le dépôt Git'
            checkout([
                $class: 'GitSCM',
                branches: [[name: 'main']], 
                userRemoteConfigs: [[url: 'https://github.com/wissal041/projet10-php.git']] 
            ])
        }
    }
}


        stage('Build') {
            steps {
                script {
                    echo 'Préparation de l\'application (Installation des dépendances PHP avec Composer)'
                    sh 'composer install'  
                }
            }
        }

        stage('Unit Tests') {
            steps {
                script {
                    echo 'Exécution des tests unitaires PHP avec PHPUnit'
                    sh 'vendor/bin/phpunit --configuration phpunit.xml'  
                }
            }
        }

        stage('Docker Image Creation') {
            steps {
                script {
                    echo 'Création de l\'image Docker pour l\'application PHP'
                    sh 'docker build -t $DOCKER_IMAGE:$DOCKER_TAG .'  
                }
            }
        }

        stage('Docker Push') {
            steps {
                script {
                    echo 'Push de l\'image Docker vers DockerHub'
                    withCredentials([usernamePassword(credentialsId: 'dockerhub-credentials', usernameVariable: 'DOCKER_USER', passwordVariable: 'DOCKER_PASS')]) {
                        sh "echo $DOCKER_PASS | docker login -u $DOCKER_USER --password-stdin $REGISTRY"
                        sh "docker push $DOCKER_IMAGE:$DOCKER_TAG"  
                    }
                }
            }
        }

        stage('Static Analysis with SonarQube') {
            steps {
                script {
                    echo 'Analyse statique du code avec SonarQube'
                    withSonarQubeEnv('SonarQube') {
                        sh 'composer install && vendor/bin/phpcs --standard=PSR2 src/'  
                    }
                }
            }
        }

        stage('Deploy') {
            steps {
                script {
                    echo 'Déploiement de l\'application sur le serveur distant'
                    sh "ssh $DEPLOY_SERVER 'docker pull $DOCKER_IMAGE:$DOCKER_TAG && docker run -d $DOCKER_IMAGE:$DOCKER_TAG'"  // Déployer l'image Docker sur le serveur distant
                }
            }
        }
    }
    
    post {
        success {
            echo 'Pipeline exécuté avec succès !'
        }
        failure {
            echo 'Une erreur est survenue durant le pipeline.'
        }
    }
}
