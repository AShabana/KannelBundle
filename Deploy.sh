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
        sudo yum -y remove byacc 2>&1 /dev/null 
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
        make && make install && return 0
        return 2
}

add_smscs(){
# add testing network and smpp
return
}

deployment_automation(){
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

add_cron_jobs(){
# tune anacron also
return
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
install_kannel
provision_kannel_wrapper
