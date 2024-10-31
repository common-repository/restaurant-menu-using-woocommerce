(function () {
    'use strict';

    function sidedish_single_product() {
        this.init = function () {
            this.toggleSideGroup();
            this.dishClick();
        }

        this.toggleSideGroup = function () {
            jQuery(document).on("click", ".sp-sidedish-group", function (e) {
                jQuery(this)
                    .next(".sp-dishes-group")
                    .toggle();
            });
        }

        this.dishClick = function () {
            var parent = this;
            jQuery(".sp-dishes-group .sp-dish").on('click', function () {
                var unique = jQuery(this).data('unique');
                var name = jQuery(this).val();
                var hash = jQuery(this).data('hash');
                var price = jQuery(this).data('price');

                if (jQuery(this).is(":checked")) {
                    parent.addSideDish(name, price, hash, unique);
                } else {
                    parent.removeSideDish(unique, price);
                }

                jQuery(document).trigger('pisol_sp_sidedish_changed');
            });
        }

        this.addSideDish = function ($name, $price, $hash, $unique) {

            var name = '<input type="hidden" name="dish' + $unique + '[name]" value="' + $name + '">'
            var price = '<input type="hidden" name="dish' + $unique + '[price]" value="' + $price + '">';
            var hash = '<input type="hidden" name="dish' + $unique + '[hash]" value="' + $hash + '">';

            this.productPrice($price);

            jQuery("#pisol-sp-form-attributes").append(name + price + hash);
        }

        this.removeSideDish = function ($unique, $price) {
            jQuery('input[name="dish' + $unique + '[name]').remove();
            jQuery('input[name="dish' + $unique + '[price]').remove();
            jQuery('input[name="dish' + $unique + '[hash]').remove();
            this.productPrice(-$price);
        }

        this.productPrice = function (side_dish_price) {
            var price = parseFloat(jQuery(".pisol-rest-price .product_price").html());
            var new_total = price + parseFloat(side_dish_price);
            jQuery(".pisol-rest-price .product_price").html(new_total.toFixed(2))
        }
    }

    function maxSelectable() {
        this.init = function () {
            var parent = this;
            this.loopThroughGroups();
            jQuery(document).on('pisol_sp_sidedish_changed', function () {
                parent.loopThroughGroups();
            });
        }

        this.loopThroughGroups = function () {
            var parent = this;
            jQuery(".sp-dishes-group").each(function () {
                if (parent.isGroupMaxLimitReached(jQuery(this))) {
                    parent.disableAllOtherDishes(jQuery(this));
                } else {
                    parent.enableAllOtherDishes(jQuery(this));
                }
            });
        }



        this.isGroupMaxLimitReached = function ($group) {
            var max = $group.data('max');
            var selected = this.selectedSideDishCount($group);
            if (selected >= max) {
                return true;
            }
            return false;
        }

        this.disableAllOtherDishes = function ($group) {
            jQuery('input[type="checkbox"]', $group).each(function () {
                if (!jQuery(this).is(":checked")) {
                    jQuery(this).prop('disabled', true);
                }
            });
        }

        this.enableAllOtherDishes = function ($group) {
            jQuery('input[type="checkbox"]', $group).each(function () {
                if (!jQuery(this).is(":checked")) {
                    jQuery(this).prop('disabled', false);
                }
            });
        }

        this.selectedSideDishCount = function ($group) {
            var selected = 0;
            jQuery('input[type="checkbox"]', $group).each(function () {
                if (jQuery(this).is(":checked")) {
                    selected++;
                }
            });
            return selected;
        }
    }

    function minRequiredSideDish() {
        this.init = function () {
            var parent = this;
            this.loopThroughGroups();
            jQuery(document).on('pisol_sp_sidedish_changed', function () {
                parent.loopThroughGroups();
            });
        }

        this.loopThroughGroups = function () {
            if (this.minSatisfiedInAllGroup()) {
                this.addToCartStatus(true);
            } else {
                this.addToCartStatus(false);
            }
        }

        this.addToCartStatus = function (state) {
            var opacity = !state ? 0.5 : 1;
            jQuery('button[name="add-to-cart"]').prop('disabled', !state).css('opacity', opacity);
        }

        this.minSatisfiedInAllGroup = function () {
            var parent = this;
            var satisfied = true;
            jQuery(".sp-dishes-group").each(function () {
                if (!parent.isGroupSatisfied(jQuery(this))) {
                    satisfied = false
                    parent.markGroupUnSatisfied(jQuery(this));
                } else {
                    parent.markGroupSatisfied(jQuery(this));
                }
            });
            return satisfied;
        }

        this.isGroupSatisfied = function ($group) {
            var group_satisfied = true;
            var min = $group.data('min');
            if (min > 0) {

                var selected_count = this.selectedSideDishCount($group);

                if (selected_count < min) {
                    group_satisfied = false;
                }

            }

            return group_satisfied;
        }

        this.selectedSideDishCount = function ($group) {
            var selected = 0;
            jQuery('input[type="checkbox"]', $group).each(function () {
                if (jQuery(this).is(":checked")) {
                    selected++;
                }
            });
            return selected;
        }

        this.markGroupUnSatisfied = function (side_dish) {
            var parent = side_dish.parent('.sp-side-dish-group')

            jQuery(".sp-sidedish-group", parent).addClass('pi-restricted');
        }

        this.markGroupSatisfied = function (side_dish) {
            var parent = side_dish.parent('.sp-side-dish-group')

            jQuery(".sp-sidedish-group", parent).removeClass('pi-restricted');
        }


    }

    jQuery(function ($) {
        var sidedish_single_product_obj = new sidedish_single_product();
        sidedish_single_product_obj.init();

        var minRequiredSideDish_obj = new minRequiredSideDish();
        minRequiredSideDish_obj.init();

        var maxSelectable_obj = new maxSelectable();
        maxSelectable_obj.init();
    });



})(jQuery)