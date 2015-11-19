# /Vagrantfile
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

    config.vm.box = "scotch/box"

    config.vm.network "forwarded_port", guest: 80, host: 8080

    config.vm.network "private_network", ip: "192.168.50.123"

    config.vm.hostname = "scotchbox"

    #config.vm.synced_folder ".", "/var/www",type: "nfs"
    config.vm.synced_folder ".", "/var/www",type: "rsync", rsync__exclude: ".git/"
end