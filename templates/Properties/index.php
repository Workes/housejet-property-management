<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Property> $properties
 */
?>
<div class="properties index content">
    <?= $this->Html->link(__('New Property'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Properties') ?></h3>
    <div class="mb-3">
    <div class="search-form">
    <?= $this->Form->create(null, ['type' => 'get']) ?>
    <?= $this->Form->control('q', [
        'label' => false,
        'placeholder' => 'Search by city, beds, baths, sqft, or price...',
        'value' => $this->request->getQuery('q')
    ]) ?>
    <?= $this->Form->button('Search') ?>
    <?= $this->Form->end() ?>
</div>

</div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <!-- <th><?= $this->Paginator->sort('id') ?></th> -->
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('city') ?></th>
                    <th><?= $this->Paginator->sort('beds') ?></th>
                    <th><?= $this->Paginator->sort('baths') ?></th>
                    <th><?= $this->Paginator->sort('sqft') ?></th>
                    <th><?= $this->Paginator->sort('price') ?></th>
                    <th><?= $this->Paginator->sort('photo') ?></th>
                    <!-- <th><?= $this->Paginator->sort('created') ?></th> -->
                    <!-- <th><?= $this->Paginator->sort('modified') ?></th> -->
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($properties as $property): ?>
                <tr>
                    <!-- <td><?= $this->Number->format($property->id) ?></td> -->
                    <td><?= h($property->title) ?></td>
                    <td><?= h($property->city) ?></td>
                    <td><?= $this->Number->format($property->beds) ?></td>
                    <td><?= $this->Number->format($property->baths) ?></td>
                    <td><?= $this->Number->format($property->sqft) ?></td>
                    <td><?= $this->Number->format($property->price) ?></td>
                    <td><?= h($property->photo) ?></td>
                    <!-- <td><?= h($property->created) ?></td> -->
                    <!-- <td><?= h($property->modified) ?></td> -->
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $property->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $property->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $property->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $property->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>