jQuery(document).ready(function ($) {

    $("#pisol_add_side_dish_group").click(function (event) {
        var group_counter = $("#pisol_sidedish_group_container").data('group-counter');
        event.preventDefault();
        $("#pisol_sidedish_group_container").append(`
        <div class="sidedish_group" data-groupid="`+ group_counter + `" data-sidedishes="0">
            <table class="sidedish-table">
            <tr>
                <td style="vertical-align:bottom;">
                    <p class="form-field" style="margin-bottom:0px;">Side Dish Group Name:<input type="text" required name="sidedish[`+ group_counter + `][group_name]" placeholder="Side Dish Group Name *"></p>
                </td>
                <td style="vertical-align:bottom;"> 
                    <button class="button pisol_add_side_dish">Add Side Dish</button> <button class="button remove_sidedish_group">Remove Side Dish Group</button>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="side_dish_container">

                    </div>
                </td>
            <tr>
                <td>
                    Max Selectable: <input type="number" min="1" required name="sidedish[`+ group_counter + `][max]" placeholder="Maximum number of dish that can be selected*" value="1">
                </td>
                <td>
                    Min Selectable: `+ (!pi_restaurant.is_pro ? '(Buy PRO version for this)' : '') + ` <input type="number" min="0" required name="sidedish[` + group_counter + `][min]" placeholder="Minimum number of dish that has to be selected*" value="0" ` + (!pi_restaurant.is_pro ? 'disabled' : "") + `>
                </td>
            </tr>
            </table>
        </div>
        `);
        group_counter++;
        $("#pisol_sidedish_group_container").data('group-counter', group_counter);
    });

    $(document).on('click', '.pisol_add_side_dish', function (event) {
        event.preventDefault();
        var parent = $(this).parent().parent().parent().parent();
        var sidedish_group = parent.parent();
        var group_counter = sidedish_group.data('groupid');
        var sidedishes = sidedish_group.data('sidedishes');

        sidedish_group.data('sidedishes', sidedishes + 1);

        $(".side_dish_container", parent).append(`
            <div class="sidedish_row">
            <input type="text" required name="sidedish[`+ group_counter + `][sidedish][` + sidedishes + `][name]" placeholder="Side Dish Name*">
            <input type="number" step="0.01" name="sidedish[`+ group_counter + `][sidedish][` + sidedishes + `][price]" placeholder="Side Dish Price">
            <button class="button button-primary remove_sidedish">Remove</button>
            </div>
        `);

    });

    $(document).on('click', '.remove_sidedish_group', function (event) {
        event.preventDefault();
        var parent = $(this).parent().parent().parent().parent();
        parent.remove();
    });

    $(document).on('click', '.remove_sidedish', function (event) {
        event.preventDefault();
        var parent = $(this).parent();
        parent.remove();
    });

    jQuery(document).on('click', ".add-side-dish-template", function (e) {
        e.preventDefault();
        var data_template = jQuery(this).data('template');
        var templates = JSON.parse(JSON.parse(data_template));
        for (var i = 0; i < templates.length; i++) {
            addTemplate(templates[i]);
        }
    });

    function addTemplate(template) {
        var group_counter = jQuery("#pisol_sidedish_group_container").data('group-counter');
        var dishes = addDishes(template.sidedish, group_counter);
        $("#pisol_sidedish_group_container").append(`
        <div class="sidedish_group" data-groupid="`+ group_counter + `" data-sidedishes="` + template.sidedish.length + `">
            <table class="sidedish-table">
            <tr>
                <td style="vertical-align:bottom;">
                    <p class="form-field" style="margin-bottom:0px;">Side Dish Group Name:<input type="text" required name="sidedish[`+ group_counter + `][group_name]" placeholder="Side Dish Group Name *" value="` + template.group_name + `"></p>
                </td>
                <td style="vertical-align:bottom;"> 
                    <button class="button pisol_add_side_dish">Add Side Dish</button> <button class="button remove_sidedish_group">Remove Side Dish Group</button>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="side_dish_container">
                    `+ dishes + `
                    </div>
                </td>
            <tr>
                <td>
                    Max Selectable: <input type="number" min="1" required name="sidedish[`+ group_counter + `][max]" placeholder="Maximum number of dish that can be selected*"  value="` + template.max + `">
                </td>
                <td>
                    Min Selectable: `+ (!pi_restaurant.is_pro ? '(Buy PRO version for this)' : '') + ` <input type="number" min="0" required name="sidedish[` + group_counter + `][min]" placeholder="Minimum number of dish that has to be selected*"  value="` + template.min + `" ` + (!pi_restaurant.is_pro ? 'disabled' : "") + `>
                </td>
            </tr>
            </table>
        </div>
        `);
        group_counter++;
        $("#pisol_sidedish_group_container").data('group-counter', group_counter);
    }

    function addDishes(dishes, group_counter) {
        var html = "";
        if (dishes.length > 0) {
            for (var i = 0; i < dishes.length; i++) {
                html += addDish(dishes[i], group_counter, i);
            }
        }
        return html;
    }

    function addDish(dish, group_counter, dish_count) {
        var html = `
        <div class="sidedish_row">
        <input type="text" required name="sidedish[`+ group_counter + `][sidedish][` + dish_count + `][name]" placeholder="Side Dish Name*" value="` + dish.name + `">
        <input type="number" step="0.01" name="sidedish[`+ group_counter + `][sidedish][` + dish_count + `][price]" placeholder="Side Dish Price"  value="` + dish.price + `">
        <button class="button button-primary remove_sidedish">Remove</button>
        </div>
        `;
        return html;
    }

    jQuery("#pisol_sidedish_group_container").sortable();


})