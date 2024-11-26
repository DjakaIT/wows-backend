<template>
  <div>
    <header>
      <nav>
        <Link href="/">Home</Link>
        <Link href="/wiki">Wiki</Link>
      </nav>
    </header>
  </div>
  <main>
    <!-- Page slot-->
    <slot />
  </main>
  <footer>
    <div>
      <div>
        <div>
          <ul>
            <li>
              footer_link_faq
            </li>
            <li>
              footer_link_imprint
            </li>
            <li>
              footer_link_privacy
            </li>
            <li>
              footer_link_contact
            </li>
          </ul>
        </div>
      </div>
      <div>
        <div>
          <p class="disclaimer">
            footer
          </p>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
