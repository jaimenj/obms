# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "ubuntu/trusty64"
  config.vm.network "forwarded_port", guest: 80, host: 8888
  config.vm.network "forwarded_port", guest: 443, host: 8889
  config.vm.network "forwarded_port", guest: 5432, host: 8890
  config.vm.provision "shell", path: "provision.sh"
  config.vm.synced_folder ".", "/vagrant"
  config.vm.provider "virtualbox" do |vb|
    vb.gui = false
    vb.customize ["modifyvm", :id, "--memory", "2024"]
  end
end
