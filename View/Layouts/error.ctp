<!DOCTYPE html>
<html lang="en">
  <head>
    <?php echo $this->Html->charset(); ?>
    <title>
    <?php echo $title_for_layout; ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
      echo $this->Html->meta('icon');
      echo $this->fetch('meta');
    ?>
   <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <?php
      echo $this->fetch('css');
      echo $this->fetch('script');
      echo $this->Html->script('jquery');
      echo $this->CakeBootstrapStarter->start(array('responsive' => true));
    ?>
  </head>

  <body>
    <div class="container">
      <?php echo $this->Session->flash(); ?>

      <?php echo $this->fetch('content'); ?>
    </div> <!-- /container -->
  </body>
</html>