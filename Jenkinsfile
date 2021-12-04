pipeline {
    agent any

    environment {
        SSH_PASSWORD = credentials('testfy_ssh_password')
    }

    stages {
        stage('Update source') {
            steps {
                sh 'sshpass -p $SSH_PASSWORD ssh -p 65002 -o StrictHostKeyChecking=no u882646258@185.224.137.7 uptime'
                sh 'sshpass -p $SSH_PASSWORD ssh -p 65002 -v u882646258@185.224.137.7'
                echo 'Update source...'
            }
        }
        stage('Update composer') {
            steps {
                echo 'Update composer..'
            }
        }
    }
}
