pipeline {
    agent any

    environment {
        SSH_PASSWORD = credentials('testfy_ssh_password')
    }

    stages {
        stage('Update source') {
            steps {
                sh 'sshpass -p $SSH_PASSWORD ssh -p 65002 -o StrictHostKeyChecking=no u882646258@185.224.137.7 uptime'
                sh 'sshpass -p $SSH_PASSWORD ssh -p 65002 -t u882646258@185.224.137.7 "cd public_html/loans/; git pull origin master"'
                echo 'Source updated'
            }
        }
        stage('Update composer') {
            steps {
                sh 'sshpass -p $SSH_PASSWORD ssh -p 65002 -t u882646258@185.224.137.7 "cd public_html/loans/; composer install"'
                echo 'Composer updated'
            }
        }
    }
}
