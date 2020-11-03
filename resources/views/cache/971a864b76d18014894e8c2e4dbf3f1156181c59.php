<?php
    // Get messages array
    $notifications = \App\Controller\Helper\Flash::getMessages();
?>

<?php if(!is_null($notifications)): ?>
<div class="notification-container">
    <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="notification" data-type="<?php echo e($notification['type']); ?>">
        <!-- Notification title and icon -->
        <div class="notification__title notification__<?php echo e($notification['type']); ?>">
            <div class="notification__title-text">
            <?php switch($notification['type']):
                case ('danger'): ?>
                    <i class="fa fa-times-circle"></i>
                    <span>Error</span>
                    <?php break; ?>
                <?php case ('info'): ?>
                    <i class="fa fa-exclamation-triangle"></i>
                    <span>Information</span>
                    <?php break; ?>
                <?php default: ?>
                    <i class="fa fa-check-circle"></i>
                    <span>Success</span>
            <?php endswitch; ?>
            </div>
            <div class="notification__title-close" id="close-notification"> Close </div>
        </div>

        <!-- Notification body -->
        <div class="notification__body">
            <?php if(is_iterable($notification['body'])): ?>
            <ul>
                <?php $__currentLoopData = $notification['body']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li> <?php echo e($item); ?> </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <?php else: ?>
            <?php echo e($notification['body']); ?>

            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\shoppingcart\resources\views/components/notification.blade.php ENDPATH**/ ?>