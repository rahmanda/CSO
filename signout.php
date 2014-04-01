<?php
  session_start();
  session_destroy();
  echo "<script>alert('Anda telah keluar dari sistem informasi kepegawaian'); window.location = '../experiment/login/index.php'</script>";
?>