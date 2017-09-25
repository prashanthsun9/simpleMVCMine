# README #

Signage and ADs players proxy server
The proxy servers can be installed on many machines inside some players group. Wo, we can have many MASTER players

### requirements ###
- The proxy must run on a machine already running the player (signage, or WF-ads) : the MASTER player machine
- The SLAVE players will have to set 2 parameters in the defaultSignage.sigrc : 
       -- proxyAdsWSUrl = the base url of the proxy on the MASTER player machine
       -- (ONLY for DS) proxyAdsScreen = the screen (0, 1,...) where the signage player is displaying

### Install the proxy on MASTER player machine ###
- Download the proxy zip file package (source + php)
- Create a subfolder inside c:\itNerusSignageCache CALLED "proxy"
- unzip the package file inside the created folder: c:\itNerusSignageCache\proxy
- Set the fixed LAN IP address of the master player machine (example: 192.168.1.100)
       
### Running ###
- change directory to c:\itNerusSignageCache
- Execute ./proxy/php/php.exe -S [machineAddress:portNumber] (example: ./proxy/php/php.exe -S 192.168.1.100:80 )
- ADD the batch file proxy/proxy.bat to the programs startup folder (or windows services)

### SLAVE players ###
Add the following parameters to the defaultSignage.sigrc file of the slaves players (the second one concerns only the DS players)

- <proxyAdsWSUrl> <<http://[proxyIpAddress:portNumber]/proxy>>

- <proxyAdsScreen> <0, 1 or...>