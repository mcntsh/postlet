Vagrant.configure('2') do |config|

  env = {
    'PROJECT_IP'          => '192.168.33.33',
    'PROJECT_NAME'        => 'local-postlet',
    'PROJECT_ROOT'        => '/var/www/postlet',
  }

  config.vm.box = 'ubuntu/trusty64'
  config.vm.network 'private_network', ip: env['PROJECT_IP']
  config.vm.hostname = env['PROJECT_NAME']
  config.vm.synced_folder '.', env['PROJECT_ROOT'], :mount_options => ['dmode=777', 'fmode=666']

  config.vm.provider "virtualbox" do |v|
    v.memory = 3072
    v.cpus = 2
  end

end
