Vagrant.configure("2") do |config|

    web_config.vm.box = "ubuntu64-191113"
    web_config.vm.box_url = "https://dl.dropboxusercontent.com/s/wtppn7w5o70r99s/ubuntu64-191113.box"

    config.vm.define "web" do |web_config|
        web_config.vm.network "forwarded_port", guest: 80, host: 8080
        web_config.vm.network "private_network", ip: "192.168.100.10"

        config.vm.synced_folder "../migration-scripts", "/vagrant/migrate/"
        config.vm.synced_folder "../creo-api", "/vagrant/creo-api/"
        config.vm.synced_folder "../client-application-bridge", "/vagrant/client-application-bridge/"
        config.vm.synced_folder "../www", "/vagrant/www/"

        web_config.vm.provision "ansible" do |ansible|
            ansible.playbook = "playbooks/dev-webserver.yml"
            ansible.inventory_path = "hosts.ini"
            ansible.verbose = "v"
        end

        web_config.vm.provider "virtualbox" do |v|
            v.customize ["modifyvm", :id, "--memory", "256"]
        end
      end

    config.vm.define "db" do |db_config|
        db_config.vm.network "forwarded_port", guest: 7474, host: 8081 # Neo4j webadmin
        db_config.vm.network "forwarded_port", guest: 9200, host: 8082 # Elasticsearch HTTP
        db_config.vm.network "private_network", ip: "192.168.100.20"

        config.vm.synced_folder "../migration-scripts", "/vagrant/migrate/"

        db_config.vm.provision "ansible" do |ansible|
            ansible.playbook = "playbooks/dev-dbserver.yml"
            ansible.inventory_path = "hosts.ini"
            ansible.verbose = "v"
        end

        db_config.vm.provider "virtualbox" do |v|
            v.customize ["modifyvm", :id, "--memory", "512"]
        end
    end
end