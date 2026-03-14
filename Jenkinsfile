pipeline {
    agent any
    // agent{
    //     docker {
    //         // image 'nitaqatdashboard-nitaqat-dashboard:latest'  // replace with the image name you built
    //         // args '-v $WORKSPACE:/var/www/html -w /var/www/html -v /var/lib/jenkins/.ssh:/root/.ssh:ro'
    //         image 'composer:2.7'   // lightweight official composer image
    //         args '-v /var/lib/jenkins/.ssh:/root/.ssh:ro'
    //     }
    // }
    

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
        // stage('Checkout') {
        //     steps {
        //         git branch: "${BRANCH}",
        //         url: 'git@github.com:ahmmedabdelalim/nitaqatDashboard.git'
        //     }
        // }

    //    stage('Install Dependencies') {
    //         steps {
    //             sh 'composer install --no-dev --optimize-autoloader'
    //         }
    //     }

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
                        composer update --no-dev --optimize-autoloader &&
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