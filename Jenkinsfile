pipeline {
    agent any

    environment {
        SERVER = "deploy@72.60.36.202"
        PROJECT_PATH = "/var/www/nitaqatDashboard"
    }

    stages {

        stage('Checkout') {
            steps {
                git branch: 'main', url: 'git@github.com:ahmmedabdelalim/nitaqatDashboard.git'
            }
        }

        stage('Deploy') {
            steps {
                sh """
                ssh $SERVER '
                    cd $PROJECT_PATH &&
                    git pull origin main &&
                    composer install --no-dev --optimize-autoloader &&
                    php artisan migrate --force &&
                    php artisan config:cache &&
                    php artisan route:cache &&
                    php artisan view:cache
                '
                """
            }
        }
    }
}