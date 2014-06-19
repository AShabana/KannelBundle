export kannel_revision=r5089
export BUNDLE_ROOT="/kannel"


install_kannel(){
        if [ ! -d $BUNDLE_ROOT ]
        then
                sudo mkdir $BUNDLE_ROOT
        fi

        if [ ! -d $BUNDLE_ROOT/src ]
        then
                sudo mkdir $BUNDLE_ROOT/src
        fi

        cd $BUNDLE_ROOT/src
        sudo yum -y remove byacc > /dev/null  2>&1 
        sudo yum -y install gcc glibc git libxml2-devel curl svn mysql mysql-devel mysql-server bison
        sudo svn co  https://svn.kannel.org/gateway/trunk@$kannel_revision
        cd trunk
        sudo ./configure  --with-mysql --disable-wap
        success=$?
        if [ ! $success  ]
        then
                echo "Failed try to ./configure "
                exit 1
        fi
        sudo make && sudo make install && sudo make clean && return 0
        return 2
}


networking_setting(){
# iptables
# tunniling
# routing 
# ipsec
}

kannel_proxy(){
return
}

add_mo_services(){
        
}

add_smscs(){
# add testing network and smpp
return
}

failed_submit_response_center(){
return        
}

system_startup_automation(){
# system start up 
return
}

install_monitor_interface(){
return
}

build_initial_kannel_config(){
return
}

add_log_rotation(){
return
}

add_satistics_engine(){
# This engine to all hassel of historical data
# collector at cron job
# data storage layer i.e. rddtools
# data representation layer i.e. 
# will it handle rotation or need our action
return
}

configuration_management_system(){
# i.e. wrapp git functionality 
# it also bakcup
}

add_cron_jobs(){
# tune anacron also
# tune server date and time 
return
}


uninstall(){
        rm -rf $BUNDLE_ROOT  
        rm -f /bin/kannel
        
}

provision_kannel_wrapper(){
        if [  -d $BUNDLE_ROOT/scripts ]
        then
                cd $BUNDLE_ROOT/scripts
        else
                sudo mkdir $BUNDLE_ROOT/scripts
                cd $_
        fi
        if [ ! -d $BUNDLE_ROOT/configs ]
        then
                sudo mkdir -p  $BUNDLE_ROOT/configs/smscs
        fi
        if [ ! -f $BUNDLE_ROOT/configs/auto-kannels.list ]
        then
                sudo touch $BUNDLE_ROOT/configs/auto-kannels.list && chown `whoami` $_
                sudo echo $BUNDLE_ROOT/configs/kannel.conf > $BUNDLE_ROOT/configs/auto-kannels.list
        fi
        if [ ! -d .git ]
        then
                sudo git init
                sudo git pull "https://github.com/AShabana/KannelBundle"
        fi
        sudo git checkout kannel
        sudo cp kannel /bin/kannel
        chmod +x $_

}
# Main

welcome # Menua of action list
install_kannel
provision_kannel_wrapper
