#TigerKanBan
A simple webbased KanBan Application.

##Installation
- Check out to a random directory e.g. "cd /opt && git clone https://github.com/farion/TigerKanBan.git"
- Link web folder somewhere to your webserver e.g. "ln -s /opt/TigerKanBan/web /var/www/tigerkanban"
- Create temp directories e.g. "mkdir /opt/TigerKanBan/cache && mkdir /opt/TigerKanBan/log"
- Set file permission e.g. "chown www-data /opt/TigerKanBan/cache -R && chown www-data /opt/TigerKanBan/log"
- Configure database e.g. "cp /opt/TigerKanBan/config/databases.dist.yml /opt/TigerKanBan/config/databases.yml && nano /opt/TigerKanBan/config/databases.yml"
- Create database and structure "./symfony doctrine:build --all"

### User and Team Data
You have to setup users and teams. This is done with the standard symfony guard feature.

TODO explain how

### Define Whiteboards
Whiteboards must be created in the database currently.

TODO explain how

### Run
That's it! Navigate your browser to the tigerkanban url and signin.

##Usage

### Basics

### Taskbox
