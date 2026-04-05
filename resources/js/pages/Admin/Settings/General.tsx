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
        title: 'General Settings',
        href: '/settings/general',
    },
];

interface GeneralSettingsProps {
    settings: {
        site_name: string;
        site_description: string;
        site_logo: string;
        site_favicon: string;
    };
}

export default function GeneralSettings({ settings }: GeneralSettingsProps) {
    const { data, setData, put, processing } = useForm({
        settings: {
            site_name: settings.site_name || '',
            site_description: settings.site_description || '',
            site_logo: settings.site_logo || '',
            site_favicon: settings.site_favicon || '',
        },
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(route('admin.settings.update', 'general'), {
            onSuccess: () => toast.success('Pengaturan umum berhasil diperbarui'),
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="General Settings" />
            <SettingsLayout>
                <div className="space-y-6">
                    <HeadingSmall
                        title="General Settings"
                        description="Basic website settings like name, description, and logo"
                    />

                    <form onSubmit={handleSubmit} className="space-y-6">
                        <div className="grid gap-2">
                            <Label htmlFor="site_name">Website Name</Label>
                            <Input
                                id="site_name"
                                type="text"
                                value={data.settings.site_name}
                                onChange={(e) =>
                                    setData('settings', {
                                        ...data.settings,
                                        site_name: e.target.value,
                                    })
                                }
                                className="mt-1 block w-full"
                                placeholder="Website Name"
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="site_description">Website Description</Label>
                            <Textarea
                                id="site_description"
                                value={data.settings.site_description}
                                onChange={(e) =>
                                    setData('settings', {
                                        ...data.settings,
                                        site_description: e.target.value,
                                    })
                                }
                                className="mt-1 block w-full"
                                placeholder="Website Description"
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="site_logo">Website Logo URL</Label>
                            <Input
                                id="site_logo"
                                type="text"
                                value={data.settings.site_logo}
                                onChange={(e) =>
                                    setData('settings', {
                                        ...data.settings,
                                        site_logo: e.target.value,
                                    })
                                }
                                className="mt-1 block w-full"
                                placeholder="Website Logo URL"
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="site_favicon">Website Favicon URL</Label>
                            <Input
                                id="site_favicon"
                                type="text"
                                value={data.settings.site_favicon}
                                onChange={(e) =>
                                    setData('settings', {
                                        ...data.settings,
                                        site_favicon: e.target.value,
                                    })
                                }
                                className="mt-1 block w-full"
                                placeholder="Website Favicon URL"
                            />
                        </div>

                        <div className="flex items-center gap-4">
                            <Button type="submit" disabled={processing}>
                                Save Settings
                            </Button>
                        </div>
                    </form>
                </div>
            </SettingsLayout>
        </AppLayout>
    );
}
