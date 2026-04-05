import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { format } from 'date-fns';
import { id } from 'date-fns/locale';

interface Tag {
    id: number;
    name: string;
    slug: string;
    description: string;
    color: string;
    created_at: string;
    updated_at: string;
}

interface Props {
    tag: Tag;
}

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Tags',
        href: route('admin.tags.index'),
    },
    {
        title: 'Show'
    },
];

export default function Show({ tag }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Tag: ${tag.name}`} />

            <div className="p-4">
                <div className="flex justify-between items-center mb-4">
                    <h1 className="text-2xl font-bold">{tag.name}</h1>
                    <div className="flex space-x-2">
                        <Link href={route('admin.tags.edit', tag.id)}>
                            <Button variant="outline">Edit</Button>
                        </Link>
                        <Link href={route('admin.tags.index')}>
                            <Button variant="outline">Back</Button>
                        </Link>
                    </div>
                </div>

                <div className="grid gap-4">
                    <Card>
                        <CardHeader>
                            <CardTitle>Tag Information</CardTitle>
                        </CardHeader>
                        <CardContent className="grid gap-4">
                            <div>
                                <h3 className="font-medium">Name</h3>
                                <p>{tag.name}</p>
                            </div>
                            <div>
                                <h3 className="font-medium">Slug</h3>
                                <p>{tag.slug}</p>
                            </div>
                            <div>
                                <h3 className="font-medium">Description</h3>
                                <p>{tag.description}</p>
                            </div>
                            <div>
                                <h3 className="font-medium">Color</h3>
                                <Badge
                                    style={{
                                        backgroundColor: tag.color,
                                        color: getContrastColor(tag.color),
                                    }}
                                >
                                    {tag.color}
                                </Badge>
                            </div>
                            <div>
                                <h3 className="font-medium">Created At</h3>
                                <p>
                                    {format(new Date(tag.created_at), 'dd MMMM yyyy HH:mm', {
                                        locale: id,
                                    })}
                                </p>
                            </div>
                            <div>
                                <h3 className="font-medium">Updated At</h3>
                                <p>
                                    {format(new Date(tag.updated_at), 'dd MMMM yyyy HH:mm', {
                                        locale: id,
                                    })}
                                </p>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AppLayout>
    );
}

// Helper function to get contrasting text color based on background color
function getContrastColor(hexColor: string): string {
    // Remove the hash if it exists
    const color = hexColor.replace('#', '');

    // Convert hex to RGB
    const r = parseInt(color.substr(0, 2), 16);
    const g = parseInt(color.substr(2, 2), 16);
    const b = parseInt(color.substr(4, 2), 16);

    // Calculate the brightness
    const brightness = (r * 299 + g * 587 + b * 114) / 1000;

    // Return black or white based on brightness
    return brightness > 128 ? '#000000' : '#FFFFFF';
}
