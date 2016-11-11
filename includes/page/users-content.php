<h4>Current Users</h3>

<ul class='list-unstyled' id='users-list'>
<? for($i = 0; $i < count($person['id']); $i++) { ?>

<li>
  <img src='/resources/images/uploads/avatar/<?=$person['image'][$i];?>.jpg' class='avatar avatar-mid' alt='Profile Avatar' />
  <?=$person['email'][$i];?>
</li>
<li>
  <?=$person['fname'][$i]." ".$person['lname'][$i];?>
</li>
<li>
  <ul class='list-inline'>
    <li>
      <strong>Role:</strong> <?=ucwords($person['role'][$i]);?>
    </li>
    <li>
      <strong>Department:</strong><?=$person['dept'][$i];?>
    </li>
  </ul>
</li>
<br />


<? } ?>
</ul>
