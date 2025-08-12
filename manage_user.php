<?php 
include('db_connect.php');
session_start();
if(isset($_GET['id'])){
    $user = $conn->query("SELECT * FROM users WHERE id =".$_GET['id']);
    foreach($user->fetch_array() as $k =>$v){
        $meta[$k] = $v;
    }
}
?>
<div class="container-fluid">
    <div id="msg"></div>

    <form action="" id="manage-user">
        <input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control"
                value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control"
                value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required autocomplete="off">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
            <?php if(isset($meta['id'])): ?>
            <small><i>Leave this blank if you don't want to change the password.</i></small>
            <?php endif; ?>
        </div>
        <?php if(isset($meta['type']) && $meta['type'] == 3): ?>
        <input type="hidden" name="type" value="3">
        <?php else: ?>
        <?php if(!isset($_GET['mtype'])): ?>
        <div class="form-group">
            <label for="type">User Type</label>
            <select name="type" id="type" class="custom-select">
                <option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected': '' ?>>LandLord
                </option>
                <option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected': '' ?>>Admin
                </option>
            </select>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </form>
</div>

<script>
$('#manage-user').submit(function(e) {
    e.preventDefault();
    start_load(); // Assuming start_load() is defined elsewhere to show a loading indicator
    $.ajax({
        url: 'ajax.php?action=save_user',
        method: 'POST',
        data: $(this).serialize(),
        success: function(resp) {
            if (resp === '1') {
                alert_toast("Data successfully saved", 'success');
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                $('#msg').html('<div class="alert alert-danger">' + resp + '</div>');
                end_load
            (); // Assuming end_load() is defined elsewhere to hide the loading indicator
            }
        },
        error: function() {
            $('#msg').html(
                '<div class="alert alert-danger">There was an error processing your request. Please try again.</div>'
                );
            end_load();
        }
    });
});
</script>

<footer
    class="footer d-flex flex-column flex-md-row align-items-center justify-content-between px-4 py-3 border-top small">
    <p class="text-muted mb-1 mb-md-0">Copyright © 2025 RentXphere </p>
</footer>