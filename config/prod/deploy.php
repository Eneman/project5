<?php

use EasyCorp\Bundle\EasyDeployBundle\Deployer\DefaultDeployer;

return new class extends DefaultDeployer
{
    public function configure()
    {
        return $this->getConfigBuilder()
            // SSH connection string to connect to the remote server (format: user@host-or-IP:port-number)
            ->server('hendrix@62.4.16.218:22')
            // the absolute path of the remote server directory where the project is deployed
            ->deployDir('/var/www/html/PROJET5')
            // the URL of the Git repository where the project code is hosted
            ->repositoryUrl('git@github.com:Eneman/project5.git')
            // the repository branch to deploy
            ->repositoryBranch('master')
            ->composerInstallFlags('--no-dev --prefer-dist --no-interaction')
        ;
    }

    // run some local or remote commands before the deployment is started
    public function beforeStartingDeploy()
    {
        // $this->runLocal('./vendor/bin/simple-phpunit');
    }
    
    public function beforePreparing()
    {
        $this->log('<h3>Copying over the .env files</>');
        $this->runRemote('cp {{ deploy_dir }}/repo/.env {{ project_dir }}');
    }

    // run some local or remote commands after the deployment is finished
    public function beforeFinishingDeploy()
    {
        // $this->runRemote('{{ console_bin }} app:my-task-name');
        // $this->runLocal('say "The deployment has finished."');
    }
};
