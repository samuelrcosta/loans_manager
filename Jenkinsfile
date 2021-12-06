pipeline {
    agent any

    environment {
        SSH_USER = credentials('testfy_ssh_user')
        SSH_PORT = credentials('testfy_ssh_port')
        SSH_IP_ADDRESS = credentials('testfy_ssh_ip_address')
        SSH_PASSWORD = credentials('testfy_ssh_password')
    }

    stages {
        stage('Update source') {
            steps {
                sh 'sshpass -p $SSH_PASSWORD ssh -p $SSH_PORT -o StrictHostKeyChecking=no $SSH_USER@$SSH_IP_ADDRESS uptime'
                sh 'sshpass -p $SSH_PASSWORD ssh -p $SSH_PORT -t $SSH_USER@$SSH_IP_ADDRESS "cd public_html/loans/; git pull origin master"'
                echo 'Source updated'
            }
        }
        stage('Update composer') {
            steps {
                sh 'sshpass -p $SSH_PASSWORD ssh -p $SSH_PORT -t $SSH_USER@$SSH_IP_ADDRESS "cd public_html/loans/; composer install"'
                echo 'Composer updated'
            }
        }
    }
}
