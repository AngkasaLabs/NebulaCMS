import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { format } from 'date-fns';
import { id } from 'date-fns/locale';

interface Category {
    id: number;
    name: string;
    slug: string;
    description: string;
    created_at: string;
    updated_at: string;
}

interface Props {
    category: Category;
}

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Categories',
        href: route('admin.categories.index'),
    },
    {
        title: 'Show',
    },
];

export default function Show({ category }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Category: ${category.name}`} />

            <div className="p-4">
                <div className="flex justify-between items-center mb-4">
                    <h1 className="text-2xl font-bold">{category.name}</h1>
                    <div className="flex space-x-2">
                        <Link href={route('admin.categories.edit', category.id)}>
                            <Button variant="outline">Edit</Button>
                        </Link>
                        <Link href={route('admin.categories.index')}>
                            <Button variant="outline">Back</Button>
                        </Link>
                    </div>
                </div>

                <div className="grid gap-4">
                    <Card>
                        <CardHeader>
                            <CardTitle>Category Information</CardTitle>
                        </CardHeader>
                        <CardContent className="grid gap-4">
                            <div>
                                <h3 className="font-medium">Name</h3>
                                <p>{category.name}</p>
                            </div>
                            <div>
                                <h3 className="font-medium">Slug</h3>
                                <p>{category.slug}</p>
                            </div>
                            <div>
                                <h3 className="font-medium">Description</h3>
                                <p>{category.description}</p>
                            </div>
                            <div>
                                <h3 className="font-medium">Created At</h3>
                                <p>
                                    {format(new Date(category.created_at), 'dd MMMM yyyy HH:mm', {
                                        locale: id,
                                    })}
                                </p>
                            </div>
                            <div>
                                <h3 className="font-medium">Updated At</h3>
                                <p>
                                    {format(new Date(category.updated_at), 'dd MMMM yyyy HH:mm', {
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
