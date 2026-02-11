<main class="py-5">
    <div class="container">
        <h2 class="mb-4 text-white">My Application History</h2>
        
        <div class="bg-light-alpha p-4 rounded">
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Company</th>
                        <th>Position Description</th>
                        <th>Date Applied</th>
                        <th>Offer Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($applicationList)): ?>
                        <?php foreach($applicationList as $app): ?>
                        <tr>
                            <td><strong><?= $app['companyName'] ?></strong></td>
                            <td><?= $app['description'] ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($app['applicationDate'])) ?></td>
                            <td>
                                <?php if($app['active']): ?>
                                    <span class="badge badge-success">Active / Open</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Closed</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">You haven't applied to any job offers yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <div class="mt-3">
                <a href="<?= FRONT_ROOT ?>StudentJobOffer/showActiveJobOffers" class="btn btn-primary">Back to Offers</a>
            </div>
        </div>
    </div>
</main>