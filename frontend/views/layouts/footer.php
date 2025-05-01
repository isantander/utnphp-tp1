</div> <!-- Cierre del div#content -->

<!-- Flowbite JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>

<!-- Nuestro JS personalizado -->
<script src="<?php echo BASE_URL; ?>/assets/js/app.js"></script>

<style>
    .nav-btn {
        @apply text-white font-medium rounded-xl text-sm px-6 py-3.5 text-center transition-all duration-300;
        min-width: 200px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 3px;
        border-radius: 4px;
    }
    
    .nav-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
</style>
</body>
</html>
