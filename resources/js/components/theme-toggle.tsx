import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { useAppearance } from '@/contexts/appearance-context';
import { Moon, Sun, Monitor } from 'lucide-react';

export function ThemeToggle() {
    const { appearance, updateAppearance } = useAppearance();

    return (
        <DropdownMenu>
            <DropdownMenuTrigger asChild>
                <Button variant="ghost" size="icon" className="h-9 w-9">
                    {appearance === 'dark' ? (
                        <Moon className="h-[1.2rem] w-[1.2rem]" />
                    ) : appearance === 'system' ? (
                        <Monitor className="h-[1.2rem] w-[1.2rem]" />
                    ) : (
                        <Sun className="h-[1.2rem] w-[1.2rem]" />
                    )}
                    <span className="sr-only">Toggle theme</span>
                </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end">
                <DropdownMenuItem onClick={() => updateAppearance('light')} className={appearance === 'light' ? 'bg-accent' : ''}>
                    <Sun className="mr-2 h-4 w-4" />
                    <span>Light</span>
                </DropdownMenuItem>
                <DropdownMenuItem onClick={() => updateAppearance('dark')} className={appearance === 'dark' ? 'bg-accent' : ''}>
                    <Moon className="mr-2 h-4 w-4" />
                    <span>Dark</span>
                </DropdownMenuItem>
                <DropdownMenuItem onClick={() => updateAppearance('system')} className={appearance === 'system' ? 'bg-accent' : ''}>
                    <Monitor className="mr-2 h-4 w-4" />
                    <span>System</span>
                </DropdownMenuItem>
            </DropdownMenuContent>
        </DropdownMenu>
    );
}
