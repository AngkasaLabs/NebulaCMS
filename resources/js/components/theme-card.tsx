import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { router } from '@inertiajs/react';
import { Trash2 } from 'lucide-react';
import { useState } from 'react';

interface ThemeCardProps {
    theme: {
        id: number;
        name: string;
        description: string | null;
        version: string;
        author: string | null;
        is_active: boolean;
        preview: string | null;
        preview_url: string | null;
        has_preview: boolean;
    };
}

export function ThemeCard({ theme }: ThemeCardProps) {
    const [isDeleteDialogOpen, setIsDeleteDialogOpen] = useState(false);

    const handleActivate = () => {
        router.post(`/admin/themes/${theme.id}/activate`);
    };

    const handleDelete = () => {
        router.delete(`/admin/themes/${theme.id}`);
        setIsDeleteDialogOpen(false);
    };

    return (
        <>
            <Card className="overflow-hidden">
                <div className="aspect-video w-full bg-muted">
                    {theme.preview_url ? (
                        <img
                            src={theme.preview_url}
                            alt={`${theme.name} screenshot`}
                            className="h-[250px] w-full object-contain"
                        />
                    ) : (
                        <div className="flex h-full items-center justify-center text-muted-foreground">
                            No preview available
                        </div>
                    )}
                </div>
                <CardHeader>
                    <CardTitle className="flex items-center justify-between">
                        {theme.name}
                        {theme.is_active && (
                            <span className="text-xs font-normal text-green-500">Active</span>
                        )}
                    </CardTitle>
                    <CardDescription>
                        Version {theme.version}
                        {theme.author && ` by ${theme.author}`}
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <p className="text-sm text-muted-foreground">
                        {theme.description || 'No description available'}
                    </p>
                </CardContent>
                <CardFooter className="flex gap-2">
                    <Button
                        variant={theme.is_active ? 'secondary' : 'default'}
                        disabled={theme.is_active}
                        onClick={handleActivate}
                        className="flex-1"
                    >
                        {theme.is_active ? 'Currently Active' : 'Activate Theme'}
                    </Button>
                    {!theme.is_active && (
                        <Dialog open={isDeleteDialogOpen} onOpenChange={setIsDeleteDialogOpen}>
                            <DialogTrigger asChild>
                                <Button variant="destructive" size="icon">
                                    <Trash2 className="h-4 w-4" />
                                </Button>
                            </DialogTrigger>
                            <DialogContent>
                                <DialogHeader>
                                    <DialogTitle>Delete Theme</DialogTitle>
                                    <DialogDescription>
                                        Are you sure you want to delete "{theme.name}"? This action cannot be undone.
                                        The theme files will be permanently removed from the server.
                                    </DialogDescription>
                                </DialogHeader>
                                <DialogFooter>
                                    <Button variant="outline" onClick={() => setIsDeleteDialogOpen(false)}>
                                        Cancel
                                    </Button>
                                    <Button variant="destructive" onClick={handleDelete}>
                                        Delete Theme
                                    </Button>
                                </DialogFooter>
                            </DialogContent>
                        </Dialog>
                    )}
                </CardFooter>
            </Card>
        </>
    );
}
