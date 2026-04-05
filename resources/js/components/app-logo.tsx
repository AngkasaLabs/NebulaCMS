import { useSidebarOptional } from '@/components/ui/sidebar';
import { cn } from '@/lib/utils';

/**
 * Logo teks: "NebulaCMS" saat sidebar terbuka, "N" saat mode ikon (collapsed).
 * Di luar SidebarProvider (mis. AppHeader) selalu menampilkan "NebulaCMS" penuh.
 */
export default function AppLogo() {
    const sidebar = useSidebarOptional();
    const isCollapsed = sidebar?.state === 'collapsed';

    return (
        <span
            className={cn(
                'font-semibold tracking-tight',
                sidebar ? 'text-sidebar-foreground' : 'text-foreground',
                isCollapsed
                    ? 'flex size-full items-center justify-center text-lg leading-none'
                    : 'truncate text-lg',
            )}
            aria-label={isCollapsed ? 'NebulaCMS' : undefined}
        >
            {isCollapsed ? 'N' : 'NebulaCMS'}
        </span>
    );
}
