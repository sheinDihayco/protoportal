
<?php
if (isset($_SESSION['employee_created']) && $_SESSION['employee_created']) {
  echo "
      <div class='alert'>
          <span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>&times;</span>
          New employee successfully added!
      </div>
      <script>
          setTimeout(function() {
              document.querySelector('.alert').style.opacity = '0';
              setTimeout(function() {
                  document.querySelector('.alert').style.display = 'none';
              }, 600);
          }, 5000);
      </script>";
  unset($_SESSION['employee_created']);
}
?>



<style>
  .alert {
    padding: 20px;
    background-color: #4CAF50;
    /* Green */
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
    border-radius: 4px;
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
  }

  .closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
  }

  .closebtn:hover {
    color: black;
  }
</style>