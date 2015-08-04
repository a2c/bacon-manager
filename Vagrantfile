# /Vagrantfile
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

    config.vm.box = "ubuntu/vivid32"

    config.vm.network "forwarded_port", guest: 80, host: 8080
    config.vm.network "forwarded_port", guest: 3306, host: 3307

    config.vm.network "private_network", ip: "192.168.50.122"

    config.vm.synced_folder ".", "/vagrant", type: "nfs"

    config.vm.provision "puppet" do |puppet|
        puppet.manifests_path = "app/vagrant"
       puppet.manifest_file  = "app.pp"
    end
end