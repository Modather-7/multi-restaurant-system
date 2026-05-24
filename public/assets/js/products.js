// ==========================================================================
// FoodGrids Core Data Store - Premium Enterprise Mock Content
// ==========================================================================

const FoodGridsMenuData = {
    categories: [
        { id: 'all', name: 'All Items' },
        { id: 'meals', name: 'Meals'},
        { id: 'burgers', name: 'Burgers'},
        { id: 'drinks', name: 'Drinks' }
    ],
    products: [
        {
            id: 1,
            restaurant_id: 1,
            category_id: 'burgers',
            name: 'Crispy Gourmet Sandwich',
            price: 85,
            image: 'assets/images/products/crispy-sandwich.jpg',
            description: 'premium chicken breast, melted sharp cheddar cheese, crisp lettuce, and signature private house sauce.',
            in_stock: true
        },
        {
            id: 2,
            restaurant_id: 1,
            category_id: 'meals',
            name: 'Grand Elite Bucket (8 Pcs)',
            price: 290,
            image: 'assets/images/products/family-bucket.png',
            description: '8 Pieces of premium crunchy chicken, large portion of salted fries, private house coleslaw, and 3 toasted buns.',
            in_stock: true
        },
        {
            id: 3,
            restaurant_id: 1,
            category_id: 'meals',
            name: 'Crispy Strips Platter',
            price: 135,
            image: 'assets/images/products/chicken-strips.jpg',
            description: '5 Pieces of premium crispy chicken tenders, french fries, fresh garlic sauce infusion, and artisanal bun.',
            in_stock: true
        },
        {
            id: 4,
            restaurant_id: 1,
            category_id: 'drinks',
            name: 'Artisanal Soda Can',
            price: 20,
            image: 'assets/images/products/coca-cola.jpeg',
            description: 'Chilled premium carbonated beverage.',
            in_stock: true
        }
    ]
};
