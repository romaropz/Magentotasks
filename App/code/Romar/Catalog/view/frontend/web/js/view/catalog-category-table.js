define([
    'jquery',
    'ko',
    'uiComponent',
    'mage/translate',
    'mage/url',
    'mage/storage'
], function ($, ko, Component, $t, url, storage) {
    'use strict';
    return Component.extend({
        items: ko.observableArray([]),
        productItems: ko.observableArray([]),
        currentCategoryId: ko.observable(""),
        currentPage: ko.observable(1),
        totalPages: ko.observable(1),
        defaults: {
            template: 'WolfSellers_Catalog/tabs'
        },
        options: {
            property: {
                children: 'children'
            }
        },
        table: {
            columns: {
                'products': $t('products'),
                'code': $t('code'),
                'presentation': $t('presentation'),
                'seeMore': $t('See more'),
                'cart': $t('Cart')
            }
        },
        initialize: function () {
            this._super();
            this.items(this.structure.items);
            this.currentCategoryId(this.structure.default_category_id);
            this.getDefaultCategoryProducts();
        },
        getColumnKeys: function () {
            return Object.keys(this.items());
        },
        getCategoryId: function (key) {
            return this.items()[key].category_id;
        },
        getCategoryLabel: function (key) {
            return $t(this.items()[key].label);
        },
        hasChildren: function (key) {
            return this.items()[key].hasOwnProperty(this.options.property.children);
        },
        getParentChild: function (key) {
            var childrenArray = this.items()[key].children;
            if (!Array.isArray(childrenArray) || childrenArray.length == 0) {
                return array();
            }
            return childrenArray;
        },
        getDefaultCategoryProducts: function () {
            var self = this;
            var payload = {
                "categoryId": this.currentCategoryId(),
                "currentPage": this.currentPage()
            };
            storage.post(
                url.build('/rest/default/V1/catalog/products/category'),
                JSON.stringify(payload))
                .done(function (response) {
                    if (response.total_pages == 0) {
                        self.productItems([]);
                    }

                    self.productItems(response.items);
                    self.currentPage(response.next_page);
                    self.totalPages(response.total_pages);
                })
                .fail(function (response) {
                });
        },
        getProducts: function (categoryId) {
            this.currentPage(1);
            this.currentCategoryId(categoryId);
            this.getDefaultCategoryProducts();
        },
        loadNextPage: function (page) {
            this.currentPage(page);
            this.getDefaultCategoryProducts();
        },
        showPagination: function () {
            return this.totalPages() > 1;
        }
    });
});
