<?php 
  defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

   if (basename($_SERVER['PHP_SELF']) == 'start.php' || basename($_SERVER['PHP_SELF']) == 'module_export.php') {
?>
<style>
.bxac-card {
  position: relative;
  border: 1px solid #d9dee8;
  border-radius: 6px;
  background: #ffffff;
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
  overflow: hidden;
  margin: 0;
}
.bx-card-hot {
  position: absolute;
  display: block;
  height: 1.75rem;
  width: auto;
  top: 0.5rem;
  right: -0.5rem;
  font-size: 1.5rem;
}
.bxac-summary {
  list-style: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 2px;
  padding: 4px 8px;
  background: linear-gradient(180deg, rgb(195, 101, 152) 0%, rgb(175, 65, 126) 55%, rgb(146, 46, 102) 100%);
  border-bottom: 1px solid rgb(136, 45, 96);
  color: #ffffff;
}
.bxac-summary::-webkit-details-marker {
  display: none;
}
.bxac-arrow {
  transition: transform 0.2s ease;
  color: #fff;
  font-size: 40px;
}
.bxac-card[open] .bxac-arrow {
  transform: rotate(90deg);
}
.bxac-title {
  margin: 0;
  font-size: 12px;
  line-height: 1.4;
  font-weight: 700;
  display: inline-flex;
  align-items: center;
}
.bxac-body {
  padding: 10px 12px;
  background: #f7fbff;
  border-left: 4px solid #c41e3a;
}
.bxac-body h4 {
  margin: 8px 0 6px;
  color: #1d3557;
}
.bxac-body ul {
  list-style-type: none;
  margin: 0 0 0 10px;
  padding: 0;
  line-height: 1.6;
}
.bxac-link {
  margin-top: 12px;
}
</style>
<?php } ?>