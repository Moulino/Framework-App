var base = angular.element('base').attr('href');
var api = base + '/api/';
var upload = base + '/upload';

var app = angular.module('app', ['ng-admin', 'ng-admin.jwt-auth']);

app.config(['NgAdminConfigurationProvider', 'ngAdminJWTAuthConfiguratorProvider', function(NgAdminConfigurationProvider, ngAdminJWTAuthConfigurator) {
    var nga = NgAdminConfigurationProvider;

    ngAdminJWTAuthConfigurator.setJWTAuthURL(base + '/login');
    ngAdminJWTAuthConfigurator.setCustomAuthHeader({
        name: 'Authorization',
        template: 'Bearer {{token}}'
    });
    
    // create an admin application
    var admin = nga.application('Administration site Werny')
        .baseApiUrl(api);

    cardgroup = createCardGroupEntity(nga);
    card = createCardEntity(nga);
    page = createPageEntity(nga);
    article = createArticleEntity(nga);

    admin.addEntity(page)
         .addEntity(article)
         .addEntity(cardgroup)
         .addEntity(card);    

    admin.menu(nga.menu()
        .addChild(nga.menu(page))
        .addChild(nga.menu(article))
        .addChild(nga.menu(cardgroup))
        .addChild(nga.menu(card))
        .addChild(nga.menu().title('Logout').icon('<span class="glyphicon glyphicon-log-out"></span>').link('logout'))
    );

    nga.configure(admin);
}]);

function createCardGroupEntity(nga) {
    var cardgroup = nga.entity('card_groups');
    cardgroup.listView().fields([
        nga.field('label', 'string').order(1),
        nga.field('description_fr', 'text').order(2),
        nga.field('description_en', 'text').order(3),
        nga.field('description_de', 'text').order(4),
        nga.field('description_nl', 'text').order(5),
    ]).listActions(['edit'], ['delete']);
    cardgroup.creationView().fields(cardgroup.listView().fields());
    cardgroup.editionView().fields(cardgroup.listView().fields());
    return cardgroup;
}

function createCardEntity(nga) {
    var card = nga.entity('cards');
    var cardgroup = nga.entity('card_groups');
    var titleFrField = nga.field('title_fr', 'string');
    var titleEnField = nga.field('title_en', 'string');
    var titleDeField = nga.field('title_de', 'string');
    var titleNlField = nga.field('title_nl', 'string');
    var uriField = nga.field('uri', 'string');
    var cardGroupIdField = nga.field('card_group_id', 'reference').label('Card group').targetEntity(cardgroup).targetField(nga.field('title'));
    var materialBoxedField = nga.field('material_boxed', 'boolean').label('Material box');

    card.listView().fields([
        titleFrField,
        nga.field('picture_file', 'string').label('Picture'),
        uriField,
        cardGroupIdField,
        materialBoxedField
    ]).listActions(['edit'], ['delete']);
    card.creationView().fields([
        titleFrField.order(1),
        titleEnField.order(2),
        titleDeField.order(3),
        titleNlField.order(4),
        nga.field('content_fr', 'wysiwyg').order(5),
        nga.field('content_en', 'wysiwyg').order(6),
        nga.field('content_de', 'wysiwyg').order(7),
        nga.field('content_nl', 'wysiwyg').order(8),
        nga.field('picture_file', 'file').uploadInformation({'url': upload, 'apifilename': 'filename'}).order(9),
        uriField.order(10),
        cardGroupIdField.order(11),
        materialBoxedField.order(12)
    ]);
    card.editionView().fields(card.creationView().fields());
    return card;
}

function createPageEntity(nga) {
    var page = nga.entity('pages');
    var slider = nga.entity('sliders');
    var cardgroup = nga.entity('card_groups');
    var nameField = nga.field('name', 'string');

    page.listView().fields([
        nameField,
        nga.field('title', 'string'),
        nga.field('banner_file', 'string').label('Banner picture'),
        //nga.field('slider_id', 'reference').label('Slider').targetEntity(slider).targetField(nga.field('title')),
        nga.field('card_group_id', 'reference').label('Card group').targetEntity(cardgroup).targetField(nga.field('title'))
    ]).listActions(['edit', 'delete']);
    page.creationView().fields([
        nameField.order(1),
        nga.field('title', 'string').order(2),
        nga.field('banner_file', 'file').uploadInformation({'url': upload, 'apifilename': 'filename'}).order(3),
        //nga.field('slider_id', 'reference').label('Slider').targetEntity(slider).targetField(nga.field('title')),
        nga.field('card_group_id', 'reference').label('Card group').targetEntity(cardgroup).targetField(nga.field('title')).order(4)
    ]);
    page.editionView().fields(page.creationView().fields());
    return page;
}

function createArticleEntity(nga) {
    var page = nga.entity('pages');
    var article = nga.entity('articles');
    var labelField = nga.field('label', 'string');
    var pageIdField = nga.field('page_id', 'reference').label('Page').targetEntity(page).targetField(nga.field('name'));
    var invertedField = nga.field('inverted', 'boolean').label('Inverted position');
    var parallaxField = nga.field('parallax', 'boolean').label('Parallax disposition');
    var orderField = nga.field('order', 'number').label('Order');

    article.listView().fields([
        labelField,
        nga.field('picture_file', 'string').label('Picture'),
        pageIdField,
        invertedField,
        parallaxField,
        orderField,
    ]).listActions(['edit', 'delete']);
    article.creationView().fields([
        labelField.order(1),
        nga.field('content_fr', 'wysiwyg').order(2),
        nga.field('content_en', 'wysiwyg').order(3),
        nga.field('content_nl', 'wysiwyg').order(4),
        nga.field('content_de', 'wysiwyg').order(5),
        nga.field('picture_file', 'file').uploadInformation({'url': upload, 'apifilename': 'filename'}).order(6),
        pageIdField.order(7),
        invertedField.order(8),
        parallaxField.order(9),
        orderField.order(10),
    ]);
    article.editionView().fields(article.creationView().fields());
    return article;
}