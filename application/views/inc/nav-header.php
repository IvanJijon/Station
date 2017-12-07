
            <ul class="nav navbar-top-links navbar-right">
				<li <?php if($lang=="fr"){?>class="open"<?php }?>>
					<a href="<?php echo base_url();?>main/change_lang/fr/<?php echo uri_string();?>"> <img src="<?php echo URL_IMG?>lang/flag-fr.jpg" width="21" height="15"/></a>
				</li>
				<li <?php if($lang=="en"){?>class="open"<?php }?>>
					<a href="<?php echo base_url();?>main/change_lang/en/<?php echo uri_string();?>"> <img src="<?php echo URL_IMG?>lang/flag-en.jpg" width="21" height="15"/></a>
				</li>
				<li <?php if($lang=="es"){?>class="open"<?php }?>>
					<a href="<?php echo base_url();?>main/change_lang/es/<?php echo uri_string();?>"> <img src="<?php echo URL_IMG?>lang/flag-es.jpg" width="21" height="15"/></a>
				</li>
				<li>
                    <a id="handle" data-toggle="tooltip" data-placement="bottom" title="Fermer&nbsp;ou&nbsp;ouvrir&nbsp;le&nbsp;menu"><i class="fa fa-dedent"></i></a>
				</li>
				<li>
				   <a  id="toggle-fullscreen"  data-toggle="tooltip" data-placement="bottom" title="Mettre&nbsp;en&nbsp;fullscreen" onclick="$(document).fullScreen(true);"><i class="fa fa-arrows-alt"></i></a>
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<?php echo $_SESSION['session-bihrdy']['infoUser']['USERNAME'] ?>
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>						
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo base_url();?>main/profil"><i class="fa fa-user fa-fw"></i> <?php echo $this->lang->line('nav-profil');?></a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url()?>main/deconnexion"><i class="fa fa-sign-out fa-fw"></i> <?php echo $this->lang->line('nav-deco');?></a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>