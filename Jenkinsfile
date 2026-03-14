pipeline {
    agent any

    environment {
        SSH_USER = "root"
        SSH_HOST = "72.60.36.202"
        SSH_KEY_ID = "nitaqat-jenkins-key"
        BRANCH = "main"
    }

    // triggers {
    //     pollSCM('H/5 * * * *') // Optional: checks every 5 min
    // }

    stages {
        stage('Checkout') {
            steps {
                git branch: "${BRANCH}", url: 'git@github.com:ahmmedabdelalim/nitaqatDashboard.git', credentialsId: 'github-token'
            }
        }

        stage('Install Dependencies') {
            steps {
                sh 'composer install --no-dev --optimize-autoloader'
            }
        }

        stage('Deploy to VPS') {
            when {
                branch "${BRANCH}"
            }
            steps {
                sshagent(['nitaqat-jenkins-key']) {
                    sh """
                    ssh $SSH_USER@$SSH_HOST '
                        cd /var/www/nitaqatDashboard &&
                        git pull origin $BRANCH &&
                        php artisan config:cache &&
                        php artisan route:cache &&
                        php artisan view:cache
                    '
                    """
                }
            }
        }
    }
}