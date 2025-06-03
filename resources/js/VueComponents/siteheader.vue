<template>
    <div class="page-header">
        <p class="page-header__p">Abalo – Ihre Online-Verkaufsplattform!</p>
        <p class="page-header__p">
            <a href="tel:+49123456789">📞 01234 56789</a>
        </p>
    </div>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>
$accentColor: #00ffd5;
$darkBg: #1a1a1a;
$textColor: #f0f0f0;
$linkHover: #ffffff;

.page-header {
    position: relative;
    top: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 8px;
    gap: 2rem;
    margin-bottom: 2px;
    width: 100%;
    background-color: #4a5568;
    color: #f0f0f0;
    padding: 1rem 2rem;
    border: 1px solid #00ffd5;
}

.page-header__p{
    font-size: 1.2rem;
    letter-spacing: 0.5px;

}

.page-header__p a {
    text-decoration: none;
    color: $accentColor;
    font-weight: bold;
    transition: color 0.2s ease-in-out;

    &:hover {
        color: $linkHover;
    }
}
</style>
