import { Head, useForm } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { toast } from 'sonner';
import HeadingSmall from '@/components/heading-small';
import SettingsLayout from '@/layouts/settings/layout';
import { Label } from '@/components/ui/label';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'SEO Settings',
        href: '/settings/seo',
    },
];

interface SeoSettingsProps {
    settings: {
        meta_title: string;
        meta_description: string;
        meta_keywords: string;
    };
}

export default function SeoSettings({ settings }: SeoSettingsProps) {
    const { data, setData, put, processing } = useForm({
        settings: {
            meta_title: settings.meta_title || '',
            meta_description: settings.meta_description || '',
            meta_keywords: settings.meta_keywords || '',
        },
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(route('admin.settings.update', 'seo'), {
            onSuccess: () => toast.success('SEO settings updated successfully'),
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="SEO Settings" />

            <SettingsLayout>
                <div className="space-y-6">
                    <HeadingSmall
                        title="SEO Settings"
                        description="Search Engine Optimization settings for better visibility"
                    />

                    <form onSubmit={handleSubmit} className="space-y-6">
                        <div className="grid gap-2">
                            <Label htmlFor="meta_title">Meta Title</Label>
                            <Input
                                id="meta_title"
                                type="text"
                                value={data.settings.meta_title}
                                onChange={(e) =>
                                    setData('settings', {
                                        ...data.settings,
                                        meta_title: e.target.value,
                                    })
                                }
                                className="mt-1 block w-full"
                                placeholder="Meta Title"
                            />
                            <p className="text-sm text-muted-foreground">
                                Title that appears in Google search results (50-60 characters)
                            </p>
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="meta_description">Meta Description</Label>
                            <Textarea
                                id="meta_description"
                                value={data.settings.meta_description}
                                onChange={(e) =>
                                    setData('settings', {
                                        ...data.settings,
                                        meta_description: e.target.value,
                                    })
                                }
                                className="mt-1 block w-full"
                                placeholder="Meta Description"
                            />
                            <p className="text-sm text-muted-foreground">
                                Description that appears in Google search results (150-160 characters)
                            </p>
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="meta_keywords">Meta Keywords</Label>
                            <Input
                                id="meta_keywords"
                                type="text"
                                value={data.settings.meta_keywords}
                                onChange={(e) =>
                                    setData('settings', {
                                        ...data.settings,
                                        meta_keywords: e.target.value,
                                    })
                                }
                                className="mt-1 block w-full"
                                placeholder="keyword-1, keyword-2, keyword-3"
                            />
                            <p className="text-sm text-muted-foreground">
                                Keywords relevant to your website (separate with commas)
                            </p>
                        </div>

                        <div className="flex items-center gap-4">
                            <Button type="submit" disabled={processing}>
                                Save SEO Settings
                            </Button>
                        </div>
                    </form>
                </div>
            </SettingsLayout>
        </AppLayout>
    );
}
