pipeline {
    agent any

    stages {
        stage('Update source') {
            node {
                sshagent (credentials: ['testfy_ssh_password']) {
                    sh 'ssh -o StrictHostKeyChecking=no u882646258@185.224.137.7 uptime'
                    sh 'ssh -v u882646258@185.224.137.7'
                    sh 'scp ./source/filename user@hostname.com:/remotehost/target'
                }
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
