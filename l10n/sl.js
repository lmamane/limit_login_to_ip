OC.L10N.register(
    "limit_login_to_ip",
    {
    "Delete" : "Izbriši",
    "Restrict login to IP addresses" : "Omeji prijavo na izbrane naslove IP",
    "Allows administrators to restrict logins to their instance to specific IP ranges." : "Omogoča skrbnikom omejitev prijav v okolje na le izbrane obsege naslovov IP.",
    "This app allows administrators to restrict login to their\nNextcloud server to specific IP ranges. Note that existing sessions will be kept\nopen.\n\nThe allowed IP ranges can be administrated using the OCC command line interface\nor graphically using the admin settings. If you plan to use the OCC tool, the\nfollowing commands would be applicable.\n\nTo whitelist `127.0.0.0/24`:\n\n- `occ config:app:set limit_login_to_ip whitelisted.ranges --value 127.0.0.0/24`\n\nTo whitelist `127.0.0.0/24` and also `192.168.0.0/24`:\n\n- `occ config:app:set limit_login_to_ip whitelisted.ranges --value 127.0.0.0/24,192.168.0.0/24`" : "Program omogoča skrbnikom omejevanje prijav v strežnik \nNextcloud z določenega obsega naslovov IP. Obstoječe seje bodo ostale\nodprte.\n\nDovoljene obsega naslovov IP je mogoče upravljati z uporabo ukaznega vmesnika OCC\nali pa grafičnega med skrbniškimi nastavitvami. Če uporabljate orodje OCC so na voljo\nnaslednji vpisni ukazi:\n\nza dodajanje na beli seznam » 127.0.0.0/24 «:\n\n- `occ config:app:set limit_login_to_ip whitelisted.ranges --value 127.0.0.0/24`\n\noziroma za dodajanje » 127.0.0.0/24« in » 192.168.0.0/24 «:\n\n- `occ config:app:set limit_login_to_ip whitelisted.ranges --value 127.0.0.0/24,192.168.0.0/24`",
    "Restrict login to IP ranges" : "Omeji prijavo na izbrane obsege naslovov IP",
    "By default, %s permits logging-in from any IP address. To limit logins to specific IP ranges, you can specify those below." : "Privzeto omogoča %s prijave s kateregakoli naslova IP. Za omejitev prijav na izbrane obsege naslovov IP je mogoče te določiti spodaj.",
    "Add" : "Dodaj",
    "Not authorized" : "Ni overjeno"
},
"nplurals=4; plural=(n%100==1 ? 0 : n%100==2 ? 1 : n%100==3 || n%100==4 ? 2 : 3);");
