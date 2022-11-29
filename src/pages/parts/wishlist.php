<?php

/**
 * @author Jay Trees <github.jay@grandel.anonaddy.me>
 */

namespace wishthis;

$scripts = array(
    '/src/assets/js/parts/wishlist-filter.js',
    '/src/assets/js/parts/wishlists.js',
);
?>
<?php foreach ($scripts as $script) { ?>
    <script defer src="<?= $script ?>?m=<?= filemtime(ROOT . $script) ?>"></script>
<?php } ?>

<div class="wishlist-filter-wrapper">
    <div class="ui stackable grid">
        <div class="column">
            <div class="flex wishlist-filter">
                <div>

                    <div class="ui floating dropdown labeled icon button filter priority">
                        <input type="hidden" name="filters" />

                        <i class="filter icon"></i>
                        <span class="text"><?= __('Filter priorities') ?></span>

                        <div class="menu">
                            <div class="ui icon search input">
                                <i class="search icon"></i>
                                <input type="text" placeholder="<?= __('Search priorities') ?>" />
                            </div>

                            <div class="divider"></div>

                            <div class="header">
                                <i class="filter icon"></i>
                                <?= __('Priorities') ?>
                            </div>

                            <div class="scrolling menu">
                                <div class="item" data-value="-1">
                                    <i class="ui empty circular label"></i>
                                    <?= __('All priorities') ?>
                                </div>

                                <div class="item" data-value="">
                                    <i class="ui white empty circular label"></i>
                                    <?= __('No priority') ?>
                                </div>

                                <div class="divider"></div>

                                <?php foreach (Wish::$priorities as $number => $priority) { ?>
                                    <div class="item" data-value="<?= $number ?>">
                                        <i class="ui <?= $priority['color'] ?> empty circular label"></i>
                                        <?= $priority['name'] ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                </div>

                <div>

                    <input type="hidden" name="style" value="grid" />
                    <div class="ui icon buttons view">
                        <button class="ui button" value="grid"><i class="grip horizontal icon"></i></button>
                        <button class="ui button" value="list"><i class="grip lines icon"></i></button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php if (isset($wishlist->id)) { ?>
    <div class="wishlist-cards" data-wishlist="<?= $wishlist->id ?>"></div>
<?php } else { ?>
    <div class="wishlist-cards"></div>
<?php } ?>

<!-- Wishlist: Create -->
<div class="ui modal wishlist-create">
    <div class="header">
        <?= __('Create a wishlist') ?>
    </div>
    <div class="content">
        <div class="description">
            <p><?= __('Choose a new name for your wishlist. Here\'s a suggestion to get you started.') ?></p>

            <form class="ui form">
                <div class="field">
                    <label><?= __('Name') ?></label>
                    <div class="ui input">
                        <input type="text" name="wishlist-name" data-default="<?= getWishlistNameSuggestion() ?>" />
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="actions">
        <div class="ui approve primary button create" title="<?= __('Create') ?>">
            <?= __('Create') ?>
        </div>
        <div class="ui deny button cancel" title="<?= __('Cancel') ?>">
            <?= __('Cancel') ?>
        </div>
    </div>
</div>

<!-- Wishlist: Rename -->
<div class="ui tiny modal wishlist-rename">
    <div class="header">
        <?= __('Rename wishlist') ?>
    </div>
    <div class="content">
        <p><?= __('How would you like to name this wishlist?') ?></p>

        <form class="ui form wishlist-rename">
            <div class="field">
                <label><?= __('Title') ?></label>
                <input type="text" name="wishlist_title" maxlength="128" />
            </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui approve primary button" title="<?= __('Rename') ?>">
            <?= __('Rename') ?>
        </div>
        <div class="ui deny button" title="<?= __('Cancel') ?>">
            <?= __('Cancel') ?>
        </div>
    </div>
</div>

<!-- Wishlist: Add a wish -->
<div class="ui modal wishlist-wish-add">
    <div class="header">
        <?= __('Add a wish') ?>
    </div>
    <div class="content">
        <div class="description">
            <p><?= __('Fill the title and/or description to add your new wish. If you just fill out the URL, wishthis will attempt to auto fill all other fields.') ?></p>

            <form class="ui form wishlist-wish-add" method="POST">
                <?php include 'wish-add.php' ?>

                <div class="ui error message"></div>
            </form>
        </div>
    </div>
    <div class="actions">
        <div class="ui primary approve button" title="<?= __('Add') ?>">
            <?= __('Add') ?>
        </div>
        <div class="ui deny button" title="<?= __('Cancel') ?>">
            <?= __('Cancel') ?>
        </div>
    </div>
</div>

<!-- Wishlist: Edit a wish -->
<div class="ui modal wishlist-wish-edit">
    <div class="header">
        <?= __('Edit wish') ?>
    </div>
    <div class="content">
        <div class="description">
            <p><?= __('If specified, wishthis will attempt to fetch all missing information from the URL.') ?></p>

            <form class="ui form wishlist-wish-edit" method="POST">
                <input type="hidden" name="wish_id" />

                <?php include 'wish-add.php' ?>

                <div class="ui error message"></div>
            </form>
        </div>
    </div>
    <div class="actions">
        <div class="ui primary approve button" title="<?= __('Save') ?>">
            <?= __('Save') ?>
        </div>
        <div class="ui deny button" title="<?= __('Cancel') ?>">
            <?= __('Cancel') ?>
        </div>
    </div>
</div>

<!-- Wish: Validate -->
<div class="ui small modal validate">
    <div class="header">
        <?= __('URL mismatch') ?>
    </div>
    <div class="content">
        <div class="description">
            <p><?= __('The URL you have entered does not seem quite right. Would you like to update it with the one I found?') ?></p>
            <p class="provider"><?= sprintf(__('According to %s, this is the canonical (correct) URL.'), '<strong class="providerName">Unknown</strong>') ?></p>

            <div class="ui form urls">
                <div class="field">
                    <label><?= __('Current') ?></label>
                    <input class="ui input current disabled" type="url" readonly />
                </div>

                <div class="field">
                    <label><?= __('Proposed') ?></label>
                    <input class="ui input proposed" type="url" />
                </div>
            </div>
        </div>
    </div>
    <div class="actions">
        <div class="ui primary approve button" title="<?= __('Yes, update') ?>">
            <?= __('Yes, update') ?>
        </div>
        <div class="ui deny button" title="<?= __('No, leave it') ?>">
            <?= __('No, leave it') ?>
        </div>
    </div>
</div>
