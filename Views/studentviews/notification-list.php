<main class="py-5">
    <div class="container">
        <h2 class="mb-4">Historial de Notificaciones</h2>
        <div class="list-group">
            <?php if(!empty($notificationList)) { 
                foreach($notificationList as $notif) { ?>
                    <a href="<?php echo FRONT_ROOT ?>StudentJobOffer/showOfferDetails/<?php echo $notif->getJobOfferId(); ?>" 
                       class="list-group-item list-group-item-action <?php echo ($notif->getIsRead()) ? 'bg-light' : 'border-primary'; ?>">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?php echo ($notif->getIsRead()) ? '✅ Leída' : '📩 Nueva'; ?></h5>
                        </div>
                        <p class="mb-1"><?php echo $notif->getMessage(); ?></p>
                    </a>
            <?php } 
            } else { ?>
                <p class="text-muted">No tienes notificaciones por el momento.</p>
            <?php } ?>
        </div>
    </div>
</main>